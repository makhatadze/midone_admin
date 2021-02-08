<?php
/**
 *  app/Http/Controllers/Backend/RolesController.php
 *
 * User:
 * Date-Time: 28.10.20
 * Time: 11:07
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */

namespace App\Http\Controllers\Backend;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RolesController extends BackendController
{

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $roles = Role::where('slug','!=','admin')->orderBy('id', 'desc')->get();

        return view('backend.directive.roles.index', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();

        return view('backend.directive.roles.create')->with('permissions', $permissions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate the role fields
        $request->validate([
            'role_name' => 'required|max:255',
            'role_slug' => 'required|max:255'
        ]);

        if (strtolower($request->role_slug) == 'admin') {
            return back()->with('warning', 'Role Slug can not be "admin"');
        }

        $role = new Role();

        $role->name = $request->role_name;
        $role->slug = strtolower($request->role_slug);
        $role->save();

        $listOfPermissions = $request->roles_permissions;


        foreach ($listOfPermissions as $permission) {
            $permission = Permission::find($permission);
            if ($permission == null) {
                continue;
            }
            $role->permissions()->attach($permission);
            $role->save();
        }

        return redirect('/admin/roles')->with('success', 'Role Added Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     */
    public function show(Role $role)
    {
        return view('backend.directive.roles.show', ['role' => $role]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();

        $rolePermissions = $role->permissions()->select('slug')->get()->toArray();

        return view('backend.directive.roles.edit', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Role $role
     *
     * @return Response
     */
    public function update(Request $request, Role $role)
    {
        //validate the role fields
        $request->validate([
            'role_name' => 'required|max:255',
            'role_slug' => 'required|max:255'
        ]);


        $role->name = $request->role_name;
        $role->slug = $request->role_slug;
        $role->save();

        $role->permissions()->detach();

        $listOfPermissions = $request->roles_permissions;

        if ($listOfPermissions) {
            foreach ($listOfPermissions as $permission) {
                $permission = Permission::find($permission);
                if ($permission == null) {
                    continue;
                }
                $role->permissions()->attach($permission);
                $role->save();
            }
        }


        return redirect('/admin/roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Role $role
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->permissions()->delete();
        $role->delete();
        $role->permissions()->detach();


        return redirect('/admin/roles');
    }
    
    public function permissions(Role $role) {
        return $role->permissions;
    }

}