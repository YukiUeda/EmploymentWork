<?php

namespace App\Http\Controllers\school;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SchoolLoginController extends Controller
{
    /**
     * 初期起動時に動くメッソド
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        return view('school.login');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $password = $request->post('password');
        $id = $request->post('id');

        Log::info('aaaaaaa');
        Auth::authenticate();
        if(Auth::attempt(['id'=>$id,'password'=>$password])){
            return view('school.top');
        }
        else{
            return view('school.login');
        }
    }
}
