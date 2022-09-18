<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BrokerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('broker')->check()) {
            if(!auth('broker')->user()->status)
            {
                auth()->guard('broker')->logout();
                return redirect()->route('broker.auth.login');
            }
            return $next($request);
        }
        return redirect()->route('broker.auth.login');
    }
}
