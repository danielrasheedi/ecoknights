<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class SimpleAuthentication
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('user_id')) {
            // Remember intended URL
            $request->session()->put('intended', $request->fullUrl());
            return redirect()->route('get-log-in')->with('error', 'Please login first.');
        }
        return $next($request);
    }
}

