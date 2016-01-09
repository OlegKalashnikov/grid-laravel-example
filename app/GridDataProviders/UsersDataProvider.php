<?php

namespace App\GridDataProviders;


use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Config;
use Paramonov\Grid\GridDataProvider;
use Paramonov\Grid\GridPagination;

class UsersDataProvider implements GridDataProvider
{
    public $query;
    public $pagination;
    public $filters;
    public $default_sorting;

    /**
     * @return Builder
     */
    public function query()
    {
        if (is_null($this->query)) {
            $this->query = User::leftJoin('user_companies', 'user_companies.id', '=', 'users.company_id');
        }
        return $this->query;
    }

    /**
     * @return GridPagination
     */
    public function pagination()
    {
        if (is_null($this->pagination)) {
            $this->pagination = new GridPagination([5, 10, 15, 25, 50]);
        }
        return $this->pagination;
    }

    /**
     * @return \Closure[]
     */
    public function filters()
    {
        if (is_null($this->filters)) {
            $this->filters = [
                'id' => function(Builder $query, $search) {
                    if (is_numeric($search)) {
                        $query->where('users.id', $search);
                    }
                },
                'name' => function(Builder $query, $search) {
                    if (is_string($search)) {
                        $query->whereRaw('LOWER(users.name) like ?', ['%' . $search . '%']);
                    }
                },
                'email' => function(Builder $query, $search) {
                    if (is_string($search)) {
                        $query->where('LOWER(users.email) like ?', ['%' . $search . '%']);
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
                            $query->whereRaw('LOWER(users.name) like ?', ['%' . $search . '%'], 'or');
                            $query->whereRaw('LOWER(users.email) like ?', ['%' . $search . '%'], 'or');
                            $query->whereRaw('LOWER(user_companies.title) like ?', ['%' . $search . '%'], 'or');

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
        return $this->filters;
    }

    /**
     * @return array
     */
    public function getDefaultSorting()
    {
        if (is_null($this->default_sorting)) {
            $this->default_sorting = ['field' => 'id', 'dir' => 'asc'];
        }
        return $this->default_sorting;
    }
}
