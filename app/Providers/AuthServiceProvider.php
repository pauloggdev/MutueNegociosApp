<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\empresa\Permission;
use App\Models\empresa\User;
use Illuminate\Contracts\Auth\Access\Gate;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        // \App\Models\empresa\Produto::class => \App\Policies\empresa\ProdutoPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(Gate $gate)
    {

        $this->registerPolicies();

        $permissions = Permission::get();
        foreach ($permissions as $permission) {
            $gate->define($permission->name, function (User $user) use ($permission) {
                return $user->hasPermission($permission);
            });
        }
        $gate->before(function (User $user, $ability) {
            if ($user->isSuperAdmin()) {
                return true;
            }
        });
    }
}
