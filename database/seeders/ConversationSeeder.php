<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class ConversationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('conversation_status')->truncate();
        $arrStatus = ['Init', 'Sedang Berjalan', 'Selesai', 'Ditolak'];

        foreach ($arrStatus as $t) {
            DB::table('conversation_status')->insert([
                'status' => $t
            ]);
        }
    }
}
