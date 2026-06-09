<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TambahStandarDeviasiKeAnalisis extends Migration
{
    public function up()
    {
        $fields = [
            'standar_deviasi' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,10',
                'default'    => 0,
                'after'      => 'permintaan_rata_rata'
            ],
        ];
        $this->forge->addColumn('analisis_stok', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('analisis_stok', 'standar_deviasi');
    }
}
