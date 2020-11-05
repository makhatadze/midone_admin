<?php
/**
 *  app/Traits/HasRolesAndPermissions.php
 *
 * User:
 * Date-Time: 28.10.20
 * Time: 10:16
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */

namespace App\Traits;

use App\Models\Permission;
use App\Models\Role;

trait HasRolesAndPermissions
{
    /**
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->roles->contains('slug', 'admin');
    }

    /**
     *
     * @return mixed
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    /**
     *
     * @return mixed
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'users_permissions');
    }

    /**
     * Check if the user has Role
     *
     * @param [type] $role
     *
     * @return boolean
     */
    public function hasRole($role)
    {
        if (strpos($role, ',') !== false) {//check if this is an list of roles

            $listOfRoles = explode(',', $role);

            foreach ($listOfRoles as $role) {
                if ($this->roles->contains('slug', $role)) {
                    return true;
                }
            }
        } else {
            if ($this->roles->contains('slug', $role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the user has Role
     *
     * @param String $permission
     *
     * @return boolean
     */
    public function hasPermission(string $permission)
    {
        return in_array($permission, array_column($this->permissions()->select('slug')->get()->toArray(), 'slug'));

    }
}