<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Services\ImageService;
use App\Services\Payment\PaymentProcessorInterface;
use App\Services\Payment\PayPalProcessor;
use App\Strategies\ResizeStrategy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PaymentProcessorInterface::class, PayPalProcessor::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        // Регистрация стратегии обработки изображений
        $this->app->singleton(ResizeStrategy::class, function ($app) {
            return new ResizeStrategy();
        });

        // Регистрация сервиса обработки изображений
        $this->app->singleton(ImageService::class, function ($app) {
            return new ImageService($app->make(ResizeStrategy::class));
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
    }
}
