<?php

namespace App\Providers;

use App\Services\CartService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema; 

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CartService::class, function ($app) {
            return new CartService();
        });
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191); 
        
        Paginator::defaultView('partials.pagination');
    }
}