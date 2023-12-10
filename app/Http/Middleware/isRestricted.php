<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class isRestricted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            //dd($request->url(), config('app.url'));
            if ($request->url() === config('app.url').'/resume'){
                if (Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isDev())) {
                    return $next($request);
                }else {
                    return redirect(RouteServiceProvider::HOME);
                }
            }else {
                return $next($request);
            }
            //return redirect(RouteServiceProvider::HOME);
        }else{
            return redirect(RouteServiceProvider::HOME);
        }
    }
}
