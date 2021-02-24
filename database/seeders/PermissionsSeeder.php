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
            array('name' => 'Read Log', 'slug' => 'read_log')
        );

        DB::table('permissions')->insert($permissions);

        DB::table('users')->insert([
            'name' => 'test test',
            'username' => 'midone@left4code.com',
            'password' => '$2y$10$zcczx.ly4nKT0G8O4eisE.QRDIvcTLPsXAZMs9zFLCFVIm3QR8Dru',
            'status' => true,
        ]);

        DB::table('roles')->insert([
            'name' => 'Admin',
            'slug' => 'admin'
        ]);

//        DB::table('users_roles')->insert([
//            'user_id' => 1,
//            'role_id' => 1
//        ]);

        foreach ($permissions as $key => $item) {
            DB::table('roles_permissions')->insert([
                'role_id' => 1,
                'permission_id' => $key + 1
            ]);

            DB::table('users_permissions')->insert([
                'user_id' => 1,
                'permission_id' => $key + 1
            ]);
        }
    }
}