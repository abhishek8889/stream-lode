<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserAndGuest
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
        if(auth()->user()){
            if(auth()->user()->status == 1){
                return redirect(url('/'.auth()->user()->unique_id));
            }
            if(auth()->user()->status == 2){
                return redirect(url('/admin/dashboard'));
            }
            return $next($request);
        }
        return $next($request);
    }
}
