<?php

namespace App\Http\Middleware;

use App\Models\Information;
use App\Providers\RouteServiceProvider;
use Closure;

class Website
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $information = Information::find(1);
        if($information->website_switch == false)
        {
            return redirect()->route('home');
        }else{
            return $next($request);
        }


    }
}
