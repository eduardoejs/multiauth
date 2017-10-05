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
        // se o usuario estiver logado com o middleware guest, ira avaliar qual o guard associado e redirecionará para
        // a pagina principal de acordo com o guard
        switch ($guard){
            case 'admin':
                if(Auth::guard($guard)->check()){
                    return redirect()->route('admin.dashboard');
                }
                break;
            default:
                if (Auth::guard($guard)->check()) {
                    return redirect('/home');
                }
                break;
        }
//        if (Auth::guard($guard)->check()) {
//            return redirect('/home');
//        }

        return $next($request);
    }
}
