<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
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

        Gate::define('isAdmin', function ($user) {
            return $user->roles->first()->slug == 'admin';
        });

        Gate::define('isManager', function ($user) {
            return $user->roles->first()->slug == 'manager';
        });

        Gate::define('isContentEditor', function ($user) {
            return $user->roles->first()->slug == 'content-editor';
        });

        // Department Create
        Gate::define('departmentCreate', function ($user) {
            return $this->hasPermission($user, 'create');
        });

        //Department update
        Gate::define('departmentsUpdate', function ($user) {
            return $this->hasPermission($user, 'create');
        });

        //Department delete
        Gate::define('departmentsDelete', function ($user) {
            return $this->hasPermission($user, 'create');
        });

        //Category create
        Gate::define('createCategories', function ($user) {
            return $this->hasPermission($user, 'create');
        });

        //Category update
        Gate::define('categoriesUpdate', function ($user) {
            return $this->hasPermission($user, 'create');
        });

        //Category delete
        Gate::define('categoriesDelete', function ($user) {
            return $this->hasPermission($user, 'create');
        });
    }

    /**
     * Check if user has permission.
     *
     * @param User $user
     * @param String $permission
     *
     * @return bool
     */

    private function hasPermission($user, $permission)
    {
        return in_array($permission, array_column($user->permissions()->select('slug')->get()->toArray(), 'slug'));
    }
}
