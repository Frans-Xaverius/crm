<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class PertanyaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pertanyaan')->truncate();

        $level1 = ['Akademik', 'Kemahasiswaan'];
        $level2 = [
            [
                'parent_id' => 1,
                'level' => 2,
                'content' => 'Jadwal Kuliah'
            ],
            [
                'parent_id' => 1,
                'level' => 2,
                'content' => 'Pengaduan Kehadiran'
            ],
            [
                'parent_id' => 2,
                'level' => 2,
                'content' => 'Pengaduan PEM'
            ],
            [
                'parent_id' => 2,
                'level' => 2,
                'content' => 'Pengaduan UKM'
            ]
        ];

        foreach ($level1 as $t) {
            DB::table('pertanyaan')->insert([
                'level' => 1,
                'content' => $t
            ]);
        }

        foreach ($level2 as $td) {
            DB::table('pertanyaan')->insert([
                'level' => $td['level'],
                'content' => $td['content'],
                'parent_id' => $td['parent_id']
            ]);
        }
    }
}
