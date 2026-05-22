<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\IncomingTransaction;
use App\Models\OutgoingTransaction;
use App\Observers\IncomingTransactionObserver;
use App\Observers\OutgoingTransactionObserver;
use Illuminate\Support\Facades\URL;

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
        // Register the IncomingTransaction observer
        IncomingTransaction::observe(IncomingTransactionObserver::class);
        
        // Register the OutgoingTransaction observer
        OutgoingTransaction::observe(OutgoingTransactionObserver::class);

        if (app()->environment('local')) {
            URL::forceScheme('https');
            URL::forceRootUrl(config('app.url'));

            // Fix for Livewire/Signed URLs behind Ngrok
            if (str_contains(config('app.url'), 'https://')) {
                $this->app['request']->server->set('HTTPS', 'on');
            }
        }
    }
}
