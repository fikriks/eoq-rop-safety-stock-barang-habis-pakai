<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_supplier' => 'CV Bima Indotama',
                'dibuat_pada' => date('Y-m-d H:i:s'),
                'diperbarui_pada' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_supplier' => 'CV Seven Anugerah Mulia',
                'dibuat_pada' => date('Y-m-d H:i:s'),
                'diperbarui_pada' => date('Y-m-d H:i:s'),
            ]
        ];

        $this->db->table('supplier')->insertBatch($data);
    }
}
