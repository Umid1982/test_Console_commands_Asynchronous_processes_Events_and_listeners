<?php

namespace App\Providers;

use App\Services\Payment\PaymentProcessorInterface;
use App\Services\Payment\PayPalProcessor;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PaymentProcessorInterface::class, PayPalProcessor::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
