<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('roles')->insert([
            [
                'name' => 'superadministrator',
                'display_name' => '超级管理员',
            ],
            [
                'name' => 'forwarder',
                'display_name' => '货代',
            ],
        ]);
    }
}
