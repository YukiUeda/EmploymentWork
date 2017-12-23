<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            switch($guard){
                case 'school':
                    return redirect()->guest('school/top');
                    break;
                case 'teacher_account':
                    return redirect()->guest('teacher/top');
                    break;
                case 'company_account':
                    return redirect()->guest('company/top');
                    break;
                case 'programmer_account':
                    return redirect()->guest('programmer/top');
                    break;
                default:
                    return redirect('/');
                    break;
            }
            return redirect('/home');
        }

        return $next($request);
    }
}
