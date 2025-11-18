<?php

namespace App\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use App\Helpers\Helper;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('Helper', Helper::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configure session early for ngrok compatibility
        $this->configureSessionForNgrok();
        
        // Force asset URLs to be absolute when using ngrok or localhost.run
        $appUrl = env('APP_URL');
        
        // Check for various tunnel services
        $isTunnelConfigured = $appUrl && (
            str_contains($appUrl, 'ngrok-free.app') || 
            str_contains($appUrl, 'ngrok-free.dev') ||
            str_contains($appUrl, 'ngrok.io') ||
            str_contains($appUrl, 'localhost.run') ||
            str_contains($appUrl, 'lhr.life')
        );
        
        if ($isTunnelConfigured) {
            // Check if the current request is coming from the tunnel
            $request = request();
            $requestHost = $request->getHost();
            $requestScheme = $request->getScheme();
            
            // Extract host from APP_URL
            $appUrlHost = parse_url($appUrl, PHP_URL_HOST);
            
            // Only apply tunnel settings if request is from tunnel domain
            $isRequestFromTunnel = $appUrlHost && (
                $requestHost === $appUrlHost ||
                str_contains($requestHost, 'ngrok-free.app') ||
                str_contains($requestHost, 'ngrok-free.dev') ||
                str_contains($requestHost, 'ngrok.io') ||
                str_contains($requestHost, 'localhost.run') ||
                str_contains($requestHost, 'lhr.life')
            );
            
            if ($isRequestFromTunnel) 
            {
                // Ensure URL uses HTTPS
                $appUrl = str_replace('http://', 'https://', $appUrl);
                
                // CRITICAL: Force root URL and scheme BEFORE any URL generation
                // This ensures Livewire's signed URLs use the correct ngrok URL
                \Illuminate\Support\Facades\URL::forceRootUrl($appUrl);
                \Illuminate\Support\Facades\URL::forceScheme('https');
                
                // Also set the app.url config to ensure consistency
                config(['app.url' => $appUrl]);
                
                // Set ASSET_URL to ensure Vite assets use the correct base URL with HTTPS
                $assetUrl = env('ASSET_URL', $appUrl);
                $assetUrl = str_replace('http://', 'https://', $assetUrl);
                config(['app.asset_url' => $assetUrl]);
                
                // Configure Vite to use HTTPS base URL
                config(['vite.build.manifest' => true]);
                
                // Force Laravel to use built assets instead of Vite dev server
                // This prevents @vite() from trying to connect to localhost:5173
                config(['vite.hmr.host' => null]);
                config(['vite.dev_server_url' => null]);
                
                // CRITICAL: Ensure Livewire can construct correct URLs for file uploads
                // Livewire automatically uses the current request URL, but we need to ensure
                // the session and CSRF tokens work correctly through ngrok
                
                // Set trusted proxies to allow ngrok headers
                // For ngrok, we need to trust all proxies since ngrok acts as a reverse proxy
                // In production, you should specify exact IPs, but for ngrok tunnels this is necessary
                // CRITICAL: This must be set early so signed URL validation works correctly
                \Illuminate\Http\Request::setTrustedProxies(
                    ['*'], // Trust all proxies when using ngrok (development only)
                    \Illuminate\Http\Request::HEADER_X_FORWARDED_FOR | 
                    \Illuminate\Http\Request::HEADER_X_FORWARDED_HOST | 
                    \Illuminate\Http\Request::HEADER_X_FORWARDED_PORT | 
                    \Illuminate\Http\Request::HEADER_X_FORWARDED_PROTO
                );
                
                // Ensure session cookies work with ngrok domain
                // CRITICAL: For ngrok, we need to ensure cookies are sent correctly
                // Since ngrok acts as a proxy, the browser sees it as same-origin, so 'lax' should work
                config(['session.domain' => null]); // Use current domain (ngrok domain) - null means current host
                config(['session.secure' => true]); // Force HTTPS cookies (required for ngrok HTTPS)
                config(['session.same_site' => 'lax']); // 'lax' works for same-origin (ngrok proxy)
                config(['session.path' => '/']); // Ensure cookies are available for all paths
                config(['session.http_only' => true]); // Security: prevent JS access
                
                // Log session config for debugging
                \Log::info('Session config for ngrok:', [
                    'domain' => config('session.domain'),
                    'secure' => config('session.secure'),
                    'same_site' => config('session.same_site'),
                    'path' => config('session.path'),
                ]);
            }
        }
    }
    
    /**
     * Configure session settings for ngrok/tunnel services
     */
    protected function configureSessionForNgrok(): void
    {
        $appUrl = env('APP_URL');
        
        // Check if using ngrok
        $isNgrok = $appUrl && (
            str_contains($appUrl, 'ngrok-free.app') || 
            str_contains($appUrl, 'ngrok-free.dev') ||
            str_contains($appUrl, 'ngrok.io') ||
            str_contains($appUrl, 'localhost.run') ||
            str_contains($appUrl, 'lhr.life')
        );
        
        if ($isNgrok) {
            // Ensure APP_URL uses HTTPS
            $appUrl = str_replace('http://', 'https://', $appUrl);
            
            // Set APP_URL early to ensure URL signing uses correct base URL
            config(['app.url' => $appUrl]);
            
            // Configure session early to ensure cookies work with ngrok
            config(['session.domain' => null]); // Use current domain
            config(['session.secure' => true]); // HTTPS required
            config(['session.same_site' => 'lax']); // Works with ngrok proxy
            config(['session.path' => '/']); // All paths
            
            // Force URL root and scheme early for signed URL generation
            \Illuminate\Support\Facades\URL::forceRootUrl($appUrl);
            \Illuminate\Support\Facades\URL::forceScheme('https');
        } else {
            // Reset session config for localhost (not using ngrok)
            // Use default values from config/session.php
            config(['session.secure' => env('SESSION_SECURE_COOKIE', false)]); // false for localhost HTTP
            config(['session.domain' => env('SESSION_DOMAIN')]); // Use env or default
            config(['session.same_site' => env('SESSION_SAME_SITE', 'lax')]); // Use env or default
        }
    }
}
