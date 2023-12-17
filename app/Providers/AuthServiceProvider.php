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
        'App\Models\Sale' => 'App\Policies\SalePolicy',
        'App\Models\Shopping' => 'App\Policies\ShoppingPolicy',
        'App\Models\Inventory' => 'App\Policies\InventoryPolicy',
        'App\Models\Initialinventory' => 'App\Policies\InitialinventoryPolicy',
        'App\Models\Brand' => 'App\Policies\BrandPolicy',
        'App\Models\Category' => 'App\Policies\CategoryPolicy',
        'App\Models\Configuration' => 'App\Policies\ConfigurationPolicy',
        'App\Models\Modelo' => 'App\Policies\ModeloPolicy',
        'App\Models\Product' => 'App\Policies\ProductPolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
        'Spatie\Permission\Models\Role' => 'App\Policies\RolePolicy',
        'Spatie\Permission\Models\Permission' => 'App\Policies\PermissionPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
