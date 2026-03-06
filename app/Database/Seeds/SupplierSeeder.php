<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_supplier' => 'CV. Maju Jaya ATK',
                'dibuat_pada'   => date('Y-m-d H:i:s'),
                'diperbarui_pada' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_supplier' => 'PT. Kertas Nusantara',
                'dibuat_pada'   => date('Y-m-d H:i:s'),
                'diperbarui_pada' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_supplier' => 'Toko Alat Listrik Sinar Baru',
                'dibuat_pada'   => date('Y-m-d H:i:s'),
                'diperbarui_pada' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('supplier')->insertBatch($data);
    }
}
