<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        ///
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('manage_users', function(User $user) {
            return $user->role === 'admin' || $user->role === 'educational_supervisor';
        });
        Gate::define('manage_users2', function(User $user) {
            return $user->role === 'admin' || $user->role === 'faculty_head';
        });
    }
}
