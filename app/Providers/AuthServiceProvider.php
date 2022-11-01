<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isTi', function ($user){
            return $user->roles->first()->slug == 'ti';
        });
        Gate::define('isAdmin', function ($user){
            return $user->roles->first()->slug == 'admin';
        });
        Gate::define('isAlm', function ($user){
            return $user->roles->first()->slug == 'alm';
        });
        Gate::define('isVal', function ($user){
            return $user->roles->first()->slug == 'user';
        });
    }
}
