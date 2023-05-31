<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->_createDefaultUsers();
    }

    protected function _createDefaultUsers()
    {
        $users = [
            1 => [
                'name'                  => 'SUPERADMIN (OWNER)',
                'user_preferred_name'   => 'Owner',
                'email'                 => 'mfahmyizwan@gmail.com',
                'user_contact_no'       => '0189031045',
                'user_username'         => 'fahmy',
                'user_password'         => password_hash('fahmy1234!', PASSWORD_DEFAULT),
                'role_id'               => '1',
            ],
        ];

        foreach ($users as $id => $user) {
            DB::table('users')->insert([
                'id' => $id,
                'name' => $user['name'],
                'user_preferred_name' => $user['user_preferred_name'],
                'email' => $user['email'],
                'user_contact_no' => $user['user_contact_no'],
                'user_username' => $user['user_username'],
                'user_password' => $user['user_password'],
                'user_gender' => 1,
                'user_status' => 1,
                'role_id' => $user['role_id'],
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
