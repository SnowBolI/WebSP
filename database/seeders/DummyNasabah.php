<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DummyNasabah extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('nasabahs')->insert([
            ['no' => '1'],
            ['nama' => 'adiz'],
            ['pokok' => '10000'],
            ['bunga' => '10000'],
            ['denda' => '10000'],
            ['total' => '100000'],
            ['account_officer' => 'adit'],
            ['keterangan' => 'kapan'],
            ['ttd' => 'sudah'],
            ['kembali' => 'kapan'],
            ['id_cabang' => '1'],
            ['id_wilayah' => '1'],
            ['id_account_officer' => '1'],
            ['id_admin_kas' => '1'],
        ]);
    }
}
