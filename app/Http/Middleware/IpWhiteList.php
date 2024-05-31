<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

            foreach ($allowed_ips as $allowed_ip) {
                Log::info('IP: ' . $allowed_ip . ' tried access ' . $request->url());
            }

            abort(404); // Return 404 if IP is not allowed
        }

        Log::info('IP: ' . $request->ip() . ' accessed ' . $request->url());
        
        return $next($request);
    }
}
