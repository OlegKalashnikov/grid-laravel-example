<?php

namespace App\Http\Controllers;


use App\GridDataProviders\UsersDataProvider;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Paramonov\Grid\GridTable;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $grid = new GridTable(new UsersDataProvider());
        if ($request->get('getData')) {
            return $grid->getData();
        }
        return view('users.index', compact('grid'));
    }
}
