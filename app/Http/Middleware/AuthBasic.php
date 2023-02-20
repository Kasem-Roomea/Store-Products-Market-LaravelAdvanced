<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthBasic
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
        error_log('enter basic auth');
        //  if (Auth::onceBasic() == null) {
        //    error_log('basic auth failed');
        //  return response()->json(['message' => 'Auth failed'], 401);
        //} else {
        //  error_log('basic auth successfully');
        return $next($request);
        // }
    }
}
