<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BuatTabelPengguna extends Migration
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
            'nama_pengguna' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'unique'     => true,
            ],
            'kata_sandi' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'peran' => [
                'type'       => 'ENUM',
                'constraint' => ['ADMIN', 'PETUGAS'],
                'default'    => 'PETUGAS',
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
        $this->forge->createTable('pengguna');
    }

    public function down()
    {
        $this->forge->dropTable('pengguna');
    }
}
