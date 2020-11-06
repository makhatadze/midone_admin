<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{

    public function run()
    {
        DB::table('permissions')->delete();
        DB::table('roles_permissions')->delete();
        DB::table('users_permissions')->delete();

        $permissions = array(
            array('name' => 'Read Role', 'slug' => 'read_role'),
            array('name' => 'Create Role', 'slug' => 'create_role'),
            array('name' => 'Edit Role', 'slug' => 'edit_role'),
            array('name' => 'Read User', 'slug' => 'read_user'),
            array('name' => 'Create User', 'slug' => 'create_user'),
            array('name' => 'Update User', 'slug' => 'update_user'),
            array('name' => 'Delete User', 'slug' => 'delete_user'),
            array('name' => 'Read Department-Category', 'slug' => 'read_department'),
            array('name' => 'Create Department-Category', 'slug' => 'create_department'),
            array('name' => 'Update Department-Category', 'slug' => 'update_department'),
            array('name' => 'Delete Department-Category', 'slug' => 'delete_department'),
            array('name' => 'Read Ticket', 'slug' => 'read_ticket'),
            array('name' => 'Confirm Ticket', 'slug' => 'confirm_ticket'),
        );

        DB::table('permissions')->insert($permissions);
    }
}