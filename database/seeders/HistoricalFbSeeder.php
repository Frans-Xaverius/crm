<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class HistoricalFbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $date_from = '2022-09-05';
        $example_data = DB::table('config_user')
            ->select('user_id')
            ->get()->toArray();

        for ($i=0; $i < 10; $i++) { 
            $date_from = str_replace('-', '/', $date_from);
            $final_date = date('Y-m-d',strtotime($date_from . "+1 days"));
            foreach($example_data as $val){
                DB::table('historical_fb')->insert([
                    'user_id' => $val->user_id,
                    'date' => $final_date,
                    'followers' => $faker->numberBetween(700, 900),
                    'likes' => $faker->numberBetween(900, 1000),
                    'comments' => $faker->numberBetween(600, 800),
                    'reads' => $faker->numberBetween(100, 200),
                    'is_solved' => $faker->numberBetween(0,1),
                    'unreads' => $faker->numberBetween(100, 200),
                    'visitors' => $faker->numberBetween(800, 1000),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            $date_from = $final_date;
        }
    }
}
