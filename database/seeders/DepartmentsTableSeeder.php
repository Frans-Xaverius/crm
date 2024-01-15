<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DepartmentsTableSeeder extends Seeder
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
                'name' => 'Supervisor',
                'department' => '-',
                'q_id' => 'a92fc73c-5468-46c5-a6ab-84b47018efbd',
                'email' => 'ellisthomasdrd@gmail.com',
                'password' => 'b!05H0Ck',
                'app' => '["fb","ig","wa","cc","web_chat","email"]'
            ],
            [
                'name' => 'Humas',
                'department' => 'Humas',
                'q_id' => 'ab8c8598-389a-4917-8cfb-5635b61d7f00',
                'email' => 'humassatu@gmail.com',
                'password' => 'b!05H0Ck',
                'app' => '["fb","ig","wa","cc","web_chat","email"]'
            ],
            [
                'name' => 'Keuangan',
                'department' => 'Keuangan',
                'q_id' => 'd1463735-f2fe-433c-96bb-19901e9804a1',
                'email' => 'keuangansatu@gmail.com',
                'password' => 'b!05H0Ck',
                'app' => '["fb","ig","wa","cc","web_chat","email"]'
            ],
            [
                'name' => 'Sosmed',
                'department' => 'Sosmed',
                'q_id' => 'a92fc73c-5468-46c5-a6ab-84b47018efbd',
                'email' => 'ellisthomasdrd@gmail.com',
                'password' => 'b!05H0Ck',
                'app' => '["fb","ig"]'
            ]
        ];
        if (DB::table('departments')->count() == 0) {
            DB::table('departments')->insert($data);
        }
    }
}
