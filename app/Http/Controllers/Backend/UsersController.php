<?php
/**
 *  app/Http/Controllers/Backend/UsersController.php
 *
 * User:
 * Date-Time: 04.11.20
 * Time: 15:04
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */

namespace App\Http\Controllers\Backend;

use App\Models\Country;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;

class UsersController extends BackendController
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        $users = User::where('email', '!=', 'midone@left4code.com')->with('profile')->get();

        // Get Roles for user
        $roles = Role::all();

        // Get Countries
        $countries = Country::all();

        return view('backend.module.users.index', [
            'users' => $users,
            'roles' => $roles,
            'countries' => $countries
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create(Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::where('id', $request->role)->first();
            $permissions = $roles->permissions;

            return $permissions;
        }

        $roles = Role::all();

//        return view('admin.users.create', ['roles' => $roles]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return bool|Application|RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        //validate the fields
        $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'birthday' => 'date',
            'email' => 'required|unique:users|email|max:255',
            'password' => 'required|between:8,255|confirmed',
            'password_confirmation' => 'required'
        ]);

        if (!$request->_token) {
            return true;
        }


        $user = new User;
        $user->name = $request->first_name . ' ' . $request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        $profile = new Profile([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birthday' => $request->birthday,
            'phone' => $request->phone,
            'country' => $request->country,
        ]);
        $user->profile()->save($profile);

        if ($request->user_role != null && $request->user_role != '0') {
            $user->roles()->attach($request->user_role);
            $user->save();

            if (count($request->permissions) > 0) {
                foreach ($request->permissions as $permission) {
                    $user->permissions()->attach($permission);
                    $user->save();
                }
            }
        }


        return redirect('/admin/users')->with('success', 'User successfully created!');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     *
     * @return array
     */
    public function show(User $user)
    {
        $rolePermissions = [];
        if ($user->roles->isNotEmpty()) {
            $rolePermissions = Role::where('id', $user->roles[0]->id)->first();
            $rolePermissions = $rolePermissions->permissions;
        }

        $allRoles = Role::all();
        $country = [];
        if ($user->profile->country) {
            $country = Country::where('code', $user->profile->country)->get()->toArray();
        }
        return [
            'user' => $user,
            'profile' => $user->profile,
            'roles' => $user->roles,
            'permissions' => $user->permissions,
            'country' => $country
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     *
     * @return User[]
     */
    public function edit(User $user)
    {
        $rolePermissions = [];
        if ($user->roles->isNotEmpty()) {
            $rolePermissions = Role::where('id', $user->roles[0]->id)->first();
            $rolePermissions = $rolePermissions->permissions;
        }

        $allRoles = Role::all();
        return [
            'user' => $user,
            'profile' => $user->profile,
            'roles' => $user->roles,
            'permissions' => $user->permissions,
            'rolePermissions' => $rolePermissions,
            'allRoles' => $allRoles
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     *
     * @return bool|Application|RedirectResponse|Redirector
     */
    public function update(Request $request, User $user)
    {
        //validate the fields
        $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'birthday' => 'date',
        ]);

        if ($user->email != $request->email) {
            $request->validate([
                'email' => 'required|unique:users|email|max:255',
            ]);
        }

        if ($request->password) {
            $request->validate([
                'password' => 'required|between:8,255|confirmed',
                'password_confirmation' => 'required'
            ]);
        }

        if (!$request->_token) {
            return true;
        }
        $user->name = $request->first_name . ' ' . $request->last_name;
        $user->email = $request->email;
        if ($request->password != null) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        if (!$user->profile) {
            $profile = new Profile([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'birthday' => $request->birthday,
                'phone' => $request->phone,
                'country' => $request->country,
            ]);
            $user->profile()->save($profile);
        } else {
            $user->profile()->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'birthday' => $request->birthday,
                'phone' => $request->phone,
                'country' => $request->country,
            ]);
        }


        $user->roles()->detach();
        $user->permissions()->detach();

        if ($request->user_role != null && $request->user_role != '0') {
            $user->roles()->attach($request->user_role);
            $user->save();
        }

        if ($request->permissions != null) {
            foreach ($request->permissions as $permission) {
                $user->permissions()->attach($permission);
                $user->save();
            }
        }
        return redirect('/admin/users')->with('success', 'User successfully updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     *
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function destroy(User $user)
    {
        if ($user->profile()) {
            $user->profile()->delete();
        }
        $user->roles()->detach();
        $user->permissions()->detach();
        $user->delete();

        return redirect('/admin/users')->with('success', 'User successfully deleted!');
    }
}
