<?php

namespace App\Http\Middleware;

use Closure;

class AddXFrameOptionsMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->header('X-Frame-Options', 'ALLOWALL');
        return $response;
    }
}

