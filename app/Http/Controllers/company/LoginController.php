<?php

namespace App\Http\Controllers\company;

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

    protected $redirectTo = '/company/top';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:company_account')->except('logout');
    }

    public function showLoginForm()
    {
        return view('company.login');
    }

    protected function guard()
    {
        return Auth::guard('company_account');
    }

    public function logout(Request $request)
    {
        Auth::guard('company_account')->logout();
        $request->session()->flush();
        $request->session()->regenerate();

        return redirect('/company/login');
    }
}
