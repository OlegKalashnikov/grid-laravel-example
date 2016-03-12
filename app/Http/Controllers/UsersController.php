<?php

namespace App\Http\Controllers;


use App\GridDataProviders\UsersDataProvider;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Paramonov\Grid\GridTable;

class UsersController extends Controller
{
    protected $users_data_provider;

    public function __construct(UsersDataProvider $users_data_provider)
    {
        $this->users_data_provider = $users_data_provider;
    }

    public function index()
    {
        $grid = new GridTable($this->users_data_provider);
        return view('users.index', compact('grid'));
    }

    public function gridData()
    {
        $grid = new GridTable($this->users_data_provider);
        return $grid->getData('users.grid.cells');
    }

    public function gridCsv()
    {
        $grid = new GridTable($this->users_data_provider);
        return $grid->getCSV('Users');
    }
}
