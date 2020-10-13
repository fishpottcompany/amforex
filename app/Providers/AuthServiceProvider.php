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

            //ADMIN SCOPE
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
            'add-admin' => 'Add admin',
            'view-admins' => 'View admins',
            'edit-admin' => 'Edit admin',
            'view-reports' => 'View Reports',

            
            //BUREAU-WORKER SCOPES
            'worker_add-customer' => 'Add customer',
            'worker_view-customers' => 'View customer',
            'worker_get-one-customer' => 'View one customer',
            'worker_view-currencies' => 'View currencies',
            'worker_add-rate' => 'Add rate',
            'worker_view-rates' => 'View rates',
            'worker_get-one-rate' => 'View one rate',
            'worker_update-rate' => 'Update rate',
            'worker_add-stock' => 'Add Stock',
            'worker_view-stocks' => 'View stock',
            'worker_add-trade' => 'Add trade',
            'worker_edit-trade' => 'Add trade',
            'worker_view-trades' => 'View trades',
            'worker_add-branch' => 'Add branch',
            'worker_view-branches' => 'View branches',
            'worker_add-worker' => 'Add worker',
            'worker_view-workers' => 'View workers',
            'worker_edit-worker' => 'Edit worker',

        ]);
        
    }

    // worker_add-customer worker_view-customers worker_get-one-customer worker_view-currencies worker_add-rate worker_view-rates worker_get-one-rate worker_update-rate worker_view-stocks worker_add-stock worker_add-trade worker_edit-trade worker_view-trades worker_add-branch worker_view-branches worker_add-worker worker_view-workers worker_edit-worker
    
    //// add-currency view-currencies get-one-currency update-currency add-rate view-rates get-one-rate update-rate add-bureau view-bureaus get-one-bureau update-bureau add-admin view-admins edit-admin view-reports
}
