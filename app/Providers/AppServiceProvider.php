<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\FortifyServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services
     */
    public function register(): void
    {
        $this->app->register(FortifyServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('isAdmin', function ($user) {
            return $user->position && $user->position->level >= 1;
        });
        Gate::define('isAssistant', function ($user) {
            return $user->position && $user->position->level >= 2;
        });
        Gate::define('isManager', function ($user) {
            return $user->position && $user->position->level == 3;
        });

        RateLimiter::for('emails', function (object $job) {
            return Limit::perMinute(1);
        });
    }

}
