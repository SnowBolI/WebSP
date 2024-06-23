<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CabangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            ['cabang' => 'Magetan'],
            ['cabang' => 'Madioen'],
            ['cabang' => 'Karangrejo'],
            ['cabang' => 'Karas'],
            ['cabang' => 'Madiun'],
            ['cabang' => 'Ohio'],
        ]);
    }
}
