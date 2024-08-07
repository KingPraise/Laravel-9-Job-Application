<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isPremiumUser
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
        if ($request->user()->user_trial > date('Y-m-d') || $request->user()->billings_end > date('Y-m-d')) {
            return $next($request);
        }
        return redirect()->route('subscribe')->with('message', 'Please subscribe to post a job');
    }
}