<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BuatTabelAnalisisStok extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_barang' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'permintaan_tahunan' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'biaya_pemesanan' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'default'    => 0,
            ],
            'biaya_penyimpanan' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'default'    => 0,
            ],
            'waktu_tunggu' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'permintaan_maksimum' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'permintaan_rata_rata' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'waktu_tunggu_maksimum' => [
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
            'terakhir_dihitung_pada' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_barang', 'barang', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('analisis_stok');
    }

    public function down()
    {
        $this->forge->dropTable('analisis_stok');
    }
}
