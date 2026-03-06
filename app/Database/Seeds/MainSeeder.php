<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        // Panggil seeder sesuai urutan ketergantungan data
        $this->call('PenggunaSeeder');
        $this->call('KoderingSeeder');
        $this->call('SupplierSeeder');
        $this->call('BarangSeeder');
        $this->call('TransaksiSeeder');
    }
}
