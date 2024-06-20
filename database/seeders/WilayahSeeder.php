<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('wilayahs')->insert([
            ['nama_wilayah' => 'mgt'],
            ['nama_wilayah' => 'plm'],
        ]);
    }
}
