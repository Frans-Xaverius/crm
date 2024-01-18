<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            // ConfigUserSeeder::class,
            // HistoricalFbSeeder::class,
            // CallCenterSeeder::class,
            DepartmentsTableSeeder::class,
            ConversationSeeder::class
        ]);
    }
}
