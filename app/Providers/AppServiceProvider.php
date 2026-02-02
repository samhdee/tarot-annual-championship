<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
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
        Gate::define('active', function () {
            return !empty(auth()->user()->is_active);
        });

        Gate::define('admin', function () {
            return !empty(auth()->user()->is_active) && !empty(auth()->user()->bgaUser->is_admin);
        });
    }
}
