<?php

namespace App\GridDataProviders;


use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Config;
use Paramonov\Grid\GridDataProvider;
use Paramonov\Grid\GridPagination;

class UsersDataProvider extends GridDataProvider
{

    /**
     * Запрос для выборки данных для таблицы
     *
     * @return Builder
     */
    public function query()
    {
        return User::leftJoin('user_companies', 'user_companies.id', '=', 'users.company_id');
    }


    /**
     * Пагинация
     *
     * @return GridPagination
     */
    public function pagination()
    {
        return new GridPagination([5, 10, 15, 25, 50]);
    }

    /**
     * Фильтрация выборки. Аналог scope в модели
     * Ключи массива должны совпадать с ключами массива из view
     *
     * @return \Closure[]
     */
    public function filters()
    {
        return [
            'id' => function(Builder $query, $search) {
                if (is_numeric($search)) {
                    $query->where('users.id', $search);
                }
            },
            'name' => function(Builder $query, $search) {
                if (is_string($search)) {
                    $query->whereRaw('LOWER(users.name) like LOWER(?)', ['%' . $search . '%']);
                }
            },
            'email' => function(Builder $query, $search) {
                if (is_string($search)) {
                    $query->whereRaw('LOWER(users.email) like LOWER(?)', ['%' . $search . '%']);
                }
            },
            'created_at' => function(Builder $query, $search) {
                if (
                    is_array($search)
                    && array_key_exists('startDate', $search)
                    && array_key_exists('endDate', $search)
                    && !is_null($search['startDate'])
                    && !is_null($search['endDate'])
                ) {
                    $start_date = Carbon::parse($search['startDate']);
                    $end_date = Carbon::parse($search['endDate']);
                    $query->where('created_at', '>=', $start_date);
                    $query->where('created_at', '<=', $end_date);
                }
            },
            'updated_at' => function(Builder $query, $search) {
                if (
                    is_array($search)
                    && array_key_exists('startDate', $search)
                    && array_key_exists('endDate', $search)
                    && !is_null($search['startDate'])
                    && !is_null($search['endDate'])
                ) {
                    $start_date = Carbon::parse($search['startDate']);
                    $end_date = Carbon::parse($search['endDate']);
                    $query->where('updated_at', '>=', $start_date);
                    $query->where('updated_at', '<=', $end_date);
                }
            },
            'user_companies.title' => function(Builder $query, $search) {
                if (is_array($search)) {
                    $query->whereIn('users.company_id', $search);
                }
            },
            'all' => function(Builder $query, $search) {
                if (is_string($search)) {
                    $query->where(function(Builder $query) use ($search) {
                        if (is_numeric($search)) {
                            $query->where('users.id', '=', $search, 'or');
                        }
                        $query->whereRaw('LOWER(users.name) like LOWER(?)', ['%' . $search . '%'], 'or');
                        $query->whereRaw('LOWER(users.email) like LOWER(?)', ['%' . $search . '%'], 'or');
                        $query->whereRaw('LOWER(user_companies.title) like LOWER(?)', ['%' . $search . '%'], 'or');

                        $database_driver = Config::get('database.default');
                        $cast = 'TEXT';
                        if ($database_driver == 'mysql') {
                            $cast = 'CHAR';
                        }

                        $query->whereRaw('CAST(users.created_at AS ' . $cast . ') like ?', ['%' . $search . '%'], 'or');
                        $query->whereRaw('CAST(users.updated_at AS ' . $cast . ') like ?', ['%' . $search . '%'], 'or');
                    });

                }
            }
        ];
    }


    /**
     * Необязательный метод
     * url для подгрузки данных
     *
     * @return string
     */
    protected function dataUrl()
    {
        return route('users.json');
    }

    /**
     * Необязательный метод
     * url для загрузки CSV-файла
     *
     * @return string
     */
    protected function csvUrl()
    {
        return route('users.csv');
    }


    /**
     * Необязательный метод
     * Поля типа "Дата"
     *
     * @return array
     */
    protected function dates()
    {
        return ['created_at', 'updated_at'];
    }

    /**
     * Необязательный метод
     * Фильтры по-умолчанию
     * Они применяются, если фильтры отсутствуют или пользователь сбросил все фильтры
     *
     * @return array
     */
    protected function dateFormat()
    {
        return 'd.m.Y в H:i:s';
    }

    /**
     * Необязательный метод
     * Сортировка по умолчанию
     *
     * @return array
     */
    protected function defaultSorting()
    {
        return ['field' => 'id', 'dir' => 'asc'];
    }
}
