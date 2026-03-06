<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PenggunaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_pengguna' => 'admin123',
                'kata_sandi'    => password_hash('123456789', PASSWORD_DEFAULT),
                'peran'         => 'ADMIN',
                'dibuat_pada'   => date('Y-m-d H:i:s'),
                'diperbarui_pada' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_pengguna' => 'petugas123',
                'kata_sandi'    => password_hash('123456789', PASSWORD_DEFAULT),
                'peran'         => 'PETUGAS',
                'dibuat_pada'   => date('Y-m-d H:i:s'),
                'diperbarui_pada' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('pengguna')->insertBatch($data);
    }
}
