<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [];

    public function boot()
    {
        $this->registerPolicies();

        // Example simplistic roles using "is_admin" column (add in users table)
        Gate::define('manage-products', function (User $user) {
            return $user->is_admin;
        });

        Gate::define('manage-cms', function (User $user) {
            return $user->is_admin;
        });

        Gate::define('view-orders', function (User $user) {
            return true; // all authenticated users can view orders (filtered in controller)
        });
    }
}