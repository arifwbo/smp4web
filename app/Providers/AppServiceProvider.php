<?php

namespace App\Providers;

use App\Models\Role;
use App\Support\ActivityLogger;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
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
        Paginator::useBootstrapFive();

        Blade::if('role', function (...$roles) {
            $user = auth()->user();

            return $user && $user->hasRole($roles);
        });

        Gate::before(function ($user, string $ability) {
            return $user->hasPermission($ability) ? true : null;
        });

        Event::listen(Login::class, function (Login $event) {
            ActivityLogger::log('auth.login', 'Login ke panel admin', $event->user->id);
        });

        Event::listen(Logout::class, function (Logout $event) {
            if ($event->user) {
                ActivityLogger::log('auth.logout', 'Logout dari panel admin', $event->user->id);
            }
        });
    }
}
