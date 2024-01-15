<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Admin',
                'email' => 'admin@crm.com',
                'password' => Hash::make('secret'),
                // 'qontak_user_id' => '',
                // 'qontak_email' => 'trial@qontak.com',
                // 'qontak_password' => 'QontakTrial',
                'email_verified_at' => now(),
                'role' => 'admin',
                'department_id' => 4
            ],
            [
                'name' => 'Supervisor',
                'email' => 'supervisor@crm.com',
                'password' => Hash::make('secret'),
                // 'qontak_user_id' => 'a92fc73c-5468-46c5-a6ab-84b47018efbd',
                // 'qontak_email' => 'ellisthomasdrd@gmail.com',
                // 'qontak_password' => 'b!05H0Ck',
                'email_verified_at' => now(),
                'role' => 'supervisor',
                'department_id' => 1
            ],
            [
                'name' => 'Humas',
                'email' => 'humas@crm.com',
                'password' => Hash::make('secret'),
                // 'qontak_user_id' => 'ab8c8598-389a-4917-8cfb-5635b61d7f00',
                // 'qontak_email' => 'humassatu@gmail.com',
                // 'qontak_password' => 'b!05H0Ck',
                'email_verified_at' => now(),
                'role' => 'agent',
                'department_id' => 2
            ],
            [
                'name' => 'Keuangan',
                'email' => 'keuangan@crm.com',
                'password' => Hash::make('secret'),
                // 'qontak_user_id' => 'd1463735-f2fe-433c-96bb-19901e9804a1',
                // 'qontak_email' => 'keuangansatu@gmail.com',
                // 'qontak_password' => 'b!05H0Ck',
                'email_verified_at' => now(),
                'role' => 'agent',
                'department_id' => 3
            ],
        ];
        if (DB::table('users')->count() == 0) {
            DB::table('users')->insert($data);
        }
    }
}
