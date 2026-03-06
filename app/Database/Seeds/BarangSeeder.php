<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BarangSeeder extends Seeder
{
    public function run()
    {
        // 1. Barang (Mengacu pada ID Kodering yang ada di KoderingSeeder)
        $barangData = [
            // ATK (Kodering ID 5)
            ['id_kodering' => 5, 'nama_barang' => 'Pulpen Pilot Hitam', 'satuan' => 'Pak', 'harga' => 25000],
            ['id_kodering' => 5, 'nama_barang' => 'Pensil 2B Faber Castell', 'satuan' => 'Lusin', 'harga' => 15000],
            ['id_kodering' => 5, 'nama_barang' => 'Penghapus Joyko Besar', 'satuan' => 'Buah', 'harga' => 5000],
            ['id_kodering' => 5, 'nama_barang' => 'Spidol Whiteboard Snowman', 'satuan' => 'Buah', 'harga' => 12000],
            ['id_kodering' => 5, 'nama_barang' => 'Paper Clip No. 3100', 'satuan' => 'Kotak', 'harga' => 8000],
            
            // Kertas (Kodering ID 6)
            ['id_kodering' => 6, 'nama_barang' => 'Kertas A4 80gr Sinar Dunia', 'satuan' => 'Rim', 'harga' => 55000],
            ['id_kodering' => 6, 'nama_barang' => 'Kertas F4 70gr Sinar Dunia', 'satuan' => 'Rim', 'harga' => 50000],
            ['id_kodering' => 6, 'nama_barang' => 'Amplop Putih Panjang', 'satuan' => 'Pak', 'harga' => 20000],
            ['id_kodering' => 6, 'nama_barang' => 'Map Snelhefter Plastik', 'satuan' => 'Lusin', 'harga' => 35000],
            ['id_kodering' => 6, 'nama_barang' => 'Sticky Notes (Post-it)', 'satuan' => 'Pad', 'harga' => 10000],

            // Bahan Komputer (Kodering ID 9)
            ['id_kodering' => 9, 'nama_barang' => 'Tinta Epson 003 Hitam', 'satuan' => 'Botol', 'harga' => 85000],
            ['id_kodering' => 9, 'nama_barang' => 'Tinta Epson 003 Warna', 'satuan' => 'Set', 'harga' => 250000],
            ['id_kodering' => 9, 'nama_barang' => 'Flashdisk 32GB Kingston', 'satuan' => 'Unit', 'harga' => 75000],

            // Perabot/Kebersihan (Kodering ID 10)
            ['id_kodering' => 10, 'nama_barang' => 'Tisu Wajah (Facial Tissue)', 'satuan' => 'Pak', 'harga' => 10000],
            ['id_kodering' => 10, 'nama_barang' => 'Sabun Cuci Tangan 500ml', 'satuan' => 'Botol', 'harga' => 25000],
            ['id_kodering' => 10, 'nama_barang' => 'Cairan Pembersih Lantai', 'satuan' => 'Pouch', 'harga' => 15000],
        ];

        $insertBarang = [];
        $insertHarga = [];
        $now = date('Y-m-d H:i:s');

        foreach ($barangData as $index => $item) {
            $id = $index + 1;
            
            $insertBarang[] = [
                'id'            => $id,
                'id_kodering'   => $item['id_kodering'],
                'nama_barang'   => $item['nama_barang'],
                'satuan'        => $item['satuan'],
                'stok'          => 0, // Akan diupdate oleh TransaksiSeeder
                'dibuat_pada'   => $now,
                'diperbarui_pada' => $now,
            ];

            $insertHarga[] = [
                'id_barang'   => $id,
                'harga_beli'  => $item['harga'],
                'dibuat_pada' => $now,
            ];
        }

        $this->db->table('barang')->insertBatch($insertBarang);
        $this->db->table('harga_barang')->insertBatch($insertHarga);
    }
}
