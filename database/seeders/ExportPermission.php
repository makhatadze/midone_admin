<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExportPermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = array(
            array('name' => 'Export Ticket', 'slug' => 'export_ticket'),
        );

        DB::table('permissions')->insert($permissions);
    }
}
