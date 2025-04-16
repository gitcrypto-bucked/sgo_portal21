<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class AutoTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $now = now();
            $lastActivity = $user->last_activity;
            if ($lastActivity && $now->diffInMinutes($lastActivity) > intval(config('autotimeout.AUTOTIMEOUT')))
            {
                return  redirect()->route('logout');
            }
            $user->last_activity = $now;
            $user->save();
        }
        return $next($request);
    }
}
