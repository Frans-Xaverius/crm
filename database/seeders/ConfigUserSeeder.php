<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ConfigUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('config_user')->insert([
            'name' => 'Stevie Ray Vaughan',
            'email' => 'srv@gmail.com',
            'application' => 'facebook'
        ]);

        DB::table('config_user')->insert([
            'name' => 'Jimi Hendrix',
            'email' => 'jimi@gmail.com',
            'application' => 'facebook'
        ]);

        DB::table('config_user')->insert([
            'name' => 'Albert King',
            'email' => 'albertking@gmail.com',
            'application' => 'facebook'
        ]);

        DB::table('config_user')->insert([
            'name' => 'John Mayer',
            'email' => 'johnmayer@gmail.com',
            'application' => 'facebook'
        ]);
    }
}
