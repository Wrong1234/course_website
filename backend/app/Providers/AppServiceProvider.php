<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Services\OtpService;
use App\Http\View\Composers\WhatsAppComposer;
use App\Services\WhatsAppService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(OtpService::class, function ($app) {
            return new OtpService();
        });

        $this->app->singleton(WhatsAppService::class, function ($app) {
            return new WhatsAppService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         Paginator::useBootstrap();
         view()->composer([
            'layouts.app',
            'welcome',
            'home',
            'courses.*'
        ], WhatsAppComposer::class);
    }
}
