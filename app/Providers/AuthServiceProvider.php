<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // ...
    ];

    // app/Providers/AuthServiceProvider.php
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin-access', function($loggedInUser) {
            return $loggedInUser->is_admin == 1;
        });


    }
}
?>