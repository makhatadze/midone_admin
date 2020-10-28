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
        $roles = Role::orderBy('id', 'desc')->get();

        return view('backend.directive.roles.index', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.directive.roles.create');
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

        $role = new Role();

        $role->name = $request->role_name;
        $role->slug = $request->role_slug;
        $role->save();

        $listOfPermissions = explode(',', $request->roles_permissions);//create array from separated/coma permissions

        foreach ($listOfPermissions as $permission) {
            $permissions = new Permission();
            $permissions->name = $permission;
            $permissions->slug = strtolower(str_replace(" ", "-", $permission));
            $permissions->save();
            $role->permissions()->attach($permissions->id);
            $role->save();
        }

        return redirect('/roles');

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
     * @return Response
     */
    public function edit(Role $role)
    {
        return view('backend.directive.roles.edit', ['role' => $role]);
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

        $role->permissions()->delete();
        $role->permissions()->detach();

        $listOfPermissions = explode(',', $request->roles_permissions);//create array from separated/coma permissions

        foreach ($listOfPermissions as $permission) {
            $permissions = new Permission();
            $permissions->name = $permission;
            $permissions->slug = strtolower(str_replace(" ", "-", $permission));
            $permissions->save();
            $role->permissions()->attach($permissions->id);
            $role->save();
        }

        return redirect('/roles');
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


        return redirect('/roles');
    }


}