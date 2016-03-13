<?php

namespace App\Http\Controllers;


use App\GridDataProviders\UsersDataProvider;
use Illuminate\Routing\Controller;
use Paramonov\Grid\GridTable;

class UsersController extends Controller
{
    protected $grid;

    public function __construct(UsersDataProvider $users_data_provider)
    {
        $this->grid = new GridTable($users_data_provider);
    }

    public function index()
    {
        return view('users.index', ['grid' => $this->grid]);
    }

    public function gridData()
    {
        return $this->grid->getData('users.grid.cells');
    }

    public function gridCsv()
    {
        return $this->grid->getCSV('Users');
    }
}
