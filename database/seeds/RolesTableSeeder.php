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
            [
                'name' => 'discharge',
                'display_name' => '排料员',
            ],
            [
                'name' => 'applydischarge',
                'display_name' => '排料申请员',
            ],
        ]);

        DB::table('permissions')->insert([
            [
                'name' => 'module_fabricdischarge',
                'display_name' => '排料申请',
            ],
            [
                'name' => 'fabricdischarge_finish',
                'display_name' => '排料员',
            ],
        ]);
        DB::table('permission_role')->insert([
            [
                'permission_id' => \App\Models\System\Permission::where('name','=','module_fabricdischarge')->value('id'),
                'role_id' => \App\Models\System\Role::where('name','=','discharge')->value('id'),
            ],
            [
                'permission_id' => \App\Models\System\Permission::where('name','=','fabricdischarge_finish')->value('id'),
                'role_id' => \App\Models\System\Role::where('name','=','discharge')->value('id'),
            ],
            [
                'permission_id' => \App\Models\System\Permission::where('name','=','module_fabricdischarge')->value('id'),
                'role_id' => \App\Models\System\Role::where('name','=','applydischarge')->value('id'),
            ],
        ]);
    }
}
