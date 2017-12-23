<?php

namespace App\Http\Controllers\programmer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:programmer_account');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $programmer = \Auth::user();
        $name = $programmer->name;
        return view('programmer.top',compact("name"));
    }
}
