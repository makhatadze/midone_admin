<?php
/**
 *  app/Providers/AuthServiceProvider.php
 *
 * User:
 * Date-Time: 06.11.20
 * Time: 10:49
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */
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

        // Read User
        Gate::define('read_user', function ($user) {
            return $this->hasPermission($user, 'read_user');
        });

        // Create User
        Gate::define('create_user', function ($user) {
            return $this->hasPermission($user, 'create_user');
        });

        // Create User
        Gate::define('update_user', function ($user) {
            return $this->hasPermission($user, 'update_user');
        });

        // Delete User
        Gate::define('delete_user', function ($user) {
            return $this->hasPermission($user, 'delete_user');
        });

        // Read Department and Category
        Gate::define('read_department', function ($user) {
            return $this->hasPermission($user, 'read_department');
        });

        // Create Department and Category
        Gate::define('create_department', function ($user) {
            return $this->hasPermission($user, 'create_department');
        });

        // Update Department and Category
        Gate::define('update_department', function ($user) {
            return $this->hasPermission($user, 'update_department');
        });

        // Delete Department and Category
        Gate::define('delete_department', function ($user) {
            return $this->hasPermission($user, 'delete_department');
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
        if ($user->hasRole('admin')) {
            return true;
        }
        return in_array($permission, array_column($user->permissions()->select('slug')->get()->toArray(), 'slug'));
    }
}
