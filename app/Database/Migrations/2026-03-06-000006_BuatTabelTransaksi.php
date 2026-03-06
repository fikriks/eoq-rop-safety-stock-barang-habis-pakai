<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BuatTabelTransaksi extends Migration
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
            'id_pengguna' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_harga' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'id_supplier' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'tipe' => [
                'type'       => 'ENUM',
                'constraint' => ['MASUK', 'KELUAR'],
            ],
            'jumlah' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tgl_transaksi' => [
                'type' => 'DATE',
            ],
            'dibuat_pada' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'diperbarui_pada' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_barang', 'barang', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_pengguna', 'pengguna', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_harga', 'harga_barang', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('id_supplier', 'supplier', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('transaksi');
    }

    public function down()
    {
        $this->forge->dropTable('transaksi');
    }
}
