<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TambahPeriodeKeAnalisis extends Migration
{
    public function up()
    {
        $fields = [
            'bulan' => ['type' => 'INT', 'constraint' => 2, 'null' => true, 'after' => 'id_barang'],
            'tahun' => ['type' => 'INT', 'constraint' => 4, 'null' => true, 'after' => 'bulan'],
        ];
        $this->forge->addColumn('analisis_stok', $fields);
        
        // Tambahkan index agar pencarian per periode cepat
        $this->db->query("CREATE INDEX idx_periode ON analisis_stok (bulan, tahun)");
    }

    public function down()
    {
        $this->forge->dropColumn('analisis_stok', ['bulan', 'tahun']);
    }
}
