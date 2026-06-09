<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UbahPresisiAnalisis extends Migration
{
    public function up()
    {
        $fields = [
            'permintaan_tahunan' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,10',
                'default'    => 0,
            ],
            'permintaan_rata_rata' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,10',
                'default'    => 0,
            ],
            'eoq' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,10',
                'default'    => 0,
            ],
            'stok_pengaman' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,10',
                'default'    => 0,
            ],
            'rop' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,10',
                'default'    => 0,
            ],
        ];
        $this->forge->modifyColumn('analisis_stok', $fields);
    }

    public function down()
    {
        // Untuk rollback, kita kembalikan ke tipe data sebelumnya jika diperlukan
        $fields = [
            'permintaan_tahunan' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'permintaan_rata_rata' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'eoq' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
            ],
            'stok_pengaman' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
            ],
            'rop' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
            ],
        ];
        $this->forge->modifyColumn('analisis_stok', $fields);
    }
}
