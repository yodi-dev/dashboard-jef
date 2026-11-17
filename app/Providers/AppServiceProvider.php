<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in production or when running behind cloud reverse proxies (Render, Cloudflare)
        if ($this->app->environment('production') || str_starts_with(config('app.url', ''), 'https://')) {
            URL::forceScheme('https');
        }

        // Dynamically configure public disk storage URL to use the incoming request host when behind proxies
        if (!app()->runningInConsole() && request()->getHost() && !in_array(request()->getHost(), ['localhost', '127.0.0.1'])) {
            $schemeAndHttpHost = request()->getSchemeAndHttpHost();
            config(['filesystems.disks.public.url' => $schemeAndHttpHost . '/storage']);
        }
    }
}
