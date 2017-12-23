<?php

namespace App\Http\Controllers\teacher;

use App\User;
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
        $this->middleware('auth:teacher_account');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data   = array();
        $user   = \Auth::user();
        $data['name'] = $user->name;
        $data['email'] = $user->email;
        return view('teacher.top',compact('data'));
    }
}
