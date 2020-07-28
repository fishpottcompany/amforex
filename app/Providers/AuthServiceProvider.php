<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
        Passport::tokensCan([
            'add-currency' => 'Add currency',
            'view-currencies' => 'View currencies',
            'get-one-currency' => 'View one currency',
            'update-currency' => 'Update currency',
            'add-rate' => 'Add rate',
            'view-rates' => 'View rates',
            'get-one-rate' => 'View one rate',
            'update-rate' => 'Update rate',
            'add-bureau' => 'Add bureau',
            'view-bureaus' => 'View bureaus',
            'get-one-bureau' => 'View one bureau',
            'update-bureau' => 'Update bureau',
        ]);
        
    }
    
    //// add-currency view-currencies get-one-currency update-currency add-rate view-rates get-one-rate update-rate add-bureau view-bureaus get-one-bureau update-bureau
}
