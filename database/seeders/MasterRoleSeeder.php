<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class MasterRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->_createDefaultRoles();
    }

    protected function _createDefaultRoles()
    {
        $roles = [
            1 => [
                'role_name'  => 'SUPER ADMINISTRATOR',
                'role_code'  => 'SUPERADMIN',
                'role_scope' => '0',
            ],
            2 => [
                'role_name'  => 'ADMINISTRATOR',
                'role_code'  => 'ADMIN',
                'role_scope' => '1',
            ],
        ];

        foreach ($roles as $id => $role) {
            DB::table('master_roles')->insert([
                'id' => $id,
                'role_name' => $role['role_name'],
                'role_code' => $role['role_code'],
                'role_status' => 1,
                'created_at' => timestamp(),
            ]);
        }
    }
}
