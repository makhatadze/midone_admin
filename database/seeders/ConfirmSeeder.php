<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfirmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = array(
            array('name' => 'Read Role', 'slug' => 'read_role'),
            array('name' => 'Un Confirm Ticket', 'slug' => 'un_confirm_ticket'),
        );

        DB::table('permissions')->insert($permissions);
    }
}
