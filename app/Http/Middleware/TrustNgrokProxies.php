<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrustNgrokProxies
{
    /**
     * Handle an incoming request.
     *
     * This middleware ensures ngrok proxies are trusted early in the request lifecycle
     * so that signed URL validation works correctly.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $appUrl = config('app.url');
        
        // Check if using ngrok
        $isNgrok = $appUrl && (
            str_contains($appUrl, 'ngrok-free.app') || 
            str_contains($appUrl, 'ngrok-free.dev') ||
            str_contains($appUrl, 'ngrok.io') ||
            str_contains($appUrl, 'localhost.run') ||
            str_contains($appUrl, 'lhr.life')
        );
        
        if ($isNgrok) {
            // Trust all proxies for ngrok (development only)
            // This must be done early so signed URL validation uses correct URL
            Request::setTrustedProxies(
                ['*'],
                Request::HEADER_X_FORWARDED_FOR | 
                Request::HEADER_X_FORWARDED_HOST | 
                Request::HEADER_X_FORWARDED_PORT | 
                Request::HEADER_X_FORWARDED_PROTO
            );
        }
        
        return $next($request);
    }
}

