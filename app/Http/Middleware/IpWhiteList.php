<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IpWhiteList
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $allowed_ips = ['127.0.0.1']; // Add your allowed IPs here

        if (!in_array($request->ip(), $allowed_ips)) {
            abort(404); // Return 404 if IP is not allowed
        }
        
        return $next($request);
    }
}
