<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->configureRateLimiting();

        parent::boot();

        // Register middleware aliases.
        // The app's middleware class is CheckRoleMiddleware.
        Route::aliasMiddleware('checkRole', \App\Http\Middleware\CheckRoleMiddleware::class);
        Route::aliasMiddleware('checkrole', \App\Http\Middleware\CheckRoleMiddleware::class);
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function ($request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}

