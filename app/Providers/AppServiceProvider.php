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
        // Force asset URLs to be absolute when using ngrok or localhost.run
        $appUrl = env('APP_URL');
        
        // Check for various tunnel services
        $isTunnel = $appUrl && (
            str_contains($appUrl, 'ngrok-free.app') || 
            str_contains($appUrl, 'localhost.run') ||
            str_contains($appUrl, 'lhr.life')
        );
        
        if ($isTunnel) {
            // Ensure URL uses HTTPS
            $appUrl = str_replace('http://', 'https://', $appUrl);
            
            // Force HTTPS for all URLs
            \Illuminate\Support\Facades\URL::forceRootUrl($appUrl);
            \Illuminate\Support\Facades\URL::forceScheme('https');
            
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
        }
    }
}
