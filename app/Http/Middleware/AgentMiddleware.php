<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentMiddleware
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
        if (Auth::guard('agent')->check()) {
            if(!auth('agent')->user()->status)
            {
                auth()->guard('agent')->logout();
                return redirect()->route('agent.auth.login');
            }
            return $next($request);
        }
        return redirect()->route('agent.auth.login');
    }
}
