<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;



class SiteAccessLimitation
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
        // $ip = request()->ip();
        // $currentUserInfo = Location::get($ip);
        // $location =  $currentUserInfo->timezone;
        // $location = explode("/",$location);
        // $region_name = strtolower($location[0]);
        // if($region_name == 'europe'){
            return redirect('coming-soon');
        // }
        // return $next($request);
    }
}
