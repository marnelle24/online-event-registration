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
        // Force asset URLs to be absolute when using ngrok
        if (env('APP_URL') && str_contains(env('APP_URL'), 'ngrok-free.app')) {
            $appUrl = env('APP_URL');
            \Illuminate\Support\Facades\URL::forceRootUrl($appUrl);
            \Illuminate\Support\Facades\URL::forceScheme('https');
            
            // Set ASSET_URL to ensure Vite assets use the correct base URL
            if (!env('ASSET_URL')) {
                config(['app.asset_url' => $appUrl]);
            }
            
            // Force Laravel to use built assets instead of Vite dev server
            // This prevents @vite() from trying to connect to localhost:5173
            config(['vite.hmr.host' => null]);
            config(['vite.dev_server_url' => null]);
        }
    }
}
