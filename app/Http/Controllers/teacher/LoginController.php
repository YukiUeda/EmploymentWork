<?php

namespace App\Http\Controllers\teacher;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $redirectTo = '/teacher/top';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:teacher_account')->except('logout');
    }

    public function showLoginForm()
    {
        return view('teacher.login');
    }

    protected function guard()
    {
        return Auth::guard('teacher_account');
    }

    public function logout(Request $request)
    {
        Auth::guard('teacher_account')->logout();
        $request->session()->flush();
        $request->session()->regenerate();

        return redirect('/teacher/login');
    }
}
