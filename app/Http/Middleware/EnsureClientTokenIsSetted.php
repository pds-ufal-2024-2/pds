<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class EnsureClientTokenIsSetted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->cookie('client_token') === null) {
            $client_token = bin2hex(random_bytes(16));
            $request->cookies->set('client_token', $client_token);
            Cookie::queue('client_token', $client_token);
        }
        return $next($request);
    }
}
