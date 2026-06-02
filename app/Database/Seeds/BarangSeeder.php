<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BarangSeeder extends Seeder
{
    public function run()
    {
        // Data Barang hasil impor dari public/sources/BHP.xlsx via python openpyxl
        $barangData = [
            ['id_kodering' => 3, 'nama_barang' => 'Isi Tabung Gas Elpiji 12 Kg', 'satuan' => 'UNIT', 'harga' => 242000],
            ['id_kodering' => 5, 'nama_barang' => 'Ballpoint Balliner 0.8 mm', 'satuan' => 'Pack', 'harga' => 81100],
            ['id_kodering' => 5, 'nama_barang' => 'Binder Clip', 'satuan' => 'Pack', 'harga' => 92000],
            ['id_kodering' => 5, 'nama_barang' => 'Gunting', 'satuan' => 'Buah', 'harga' => 12400],
            ['id_kodering' => 5, 'nama_barang' => 'Hekter/Stepler/Stepless 23/10-H', 'satuan' => 'Buah', 'harga' => 93000],
            ['id_kodering' => 5, 'nama_barang' => 'Hekter/Stepler/Stepless sr-45t', 'satuan' => 'Buah', 'harga' => 20700],
            ['id_kodering' => 5, 'nama_barang' => 'Kertas HVS 80gram A4', 'satuan' => 'Rim', 'harga' => 68250],
            ['id_kodering' => 5, 'nama_barang' => 'Kertas HVS 80gram F4', 'satuan' => 'Rim', 'harga' => 84000],
            ['id_kodering' => 5, 'nama_barang' => 'Isi Hekter Ukuran Standar', 'satuan' => 'Pack', 'harga' => 64100],
            ['id_kodering' => 5, 'nama_barang' => 'Isolasi/Lakban', 'satuan' => 'Buah', 'harga' => 29500],
            ['id_kodering' => 5, 'nama_barang' => 'Mistar/Penggaris', 'satuan' => 'Buah', 'harga' => 18100],
            ['id_kodering' => 5, 'nama_barang' => 'Ordner', 'satuan' => 'Pack', 'harga' => 228300],
            ['id_kodering' => 5, 'nama_barang' => 'Penghapus Pensil', 'satuan' => 'Pack', 'harga' => 5100],
            ['id_kodering' => 5, 'nama_barang' => 'Pensil 2B', 'satuan' => 'Pack', 'harga' => 59700],
            ['id_kodering' => 5, 'nama_barang' => 'Post It Plastik', 'satuan' => 'Pack', 'harga' => 8400],
            ['id_kodering' => 5, 'nama_barang' => 'Spidol White Board Permanen', 'satuan' => 'Buah', 'harga' => 10200],
            ['id_kodering' => 5, 'nama_barang' => 'Tipe-X', 'satuan' => 'Pack', 'harga' => 39300],
            ['id_kodering' => 5, 'nama_barang' => 'Amplop uk 104', 'satuan' => 'Dus', 'harga' => 16800],
            ['id_kodering' => 5, 'nama_barang' => 'Amplop uk 90', 'satuan' => 'Dus', 'harga' => 23300],
            ['id_kodering' => 5, 'nama_barang' => 'Pulpen/Ballpoint Gel', 'satuan' => 'PACK', 'harga' => 47896],
            ['id_kodering' => 5, 'nama_barang' => 'Penjepit Kertas No 105', 'satuan' => 'PACK', 'harga' => 3111],
            ['id_kodering' => 5, 'nama_barang' => 'Penjepit Kertas No 155', 'satuan' => 'PACK', 'harga' => 9953],
            ['id_kodering' => 5, 'nama_barang' => 'Penjepit Kertas No 260', 'satuan' => 'PACK', 'harga' => 16069],
            ['id_kodering' => 5, 'nama_barang' => 'Pembolong Kertas No 85', 'satuan' => 'Buah', 'harga' => 51490],
            ['id_kodering' => 5, 'nama_barang' => 'Tinta Stampel', 'satuan' => 'Buah', 'harga' => 21771],
            ['id_kodering' => 5, 'nama_barang' => 'Ordner Ukuran F4', 'satuan' => 'Buah', 'harga' => 55000],
            ['id_kodering' => 5, 'nama_barang' => 'Post It Plastik', 'satuan' => 'Pack', 'harga' => 8239],
            ['id_kodering' => 5, 'nama_barang' => 'Sticky Notes 653 657', 'satuan' => 'Set', 'harga' => 7257],
            ['id_kodering' => 5, 'nama_barang' => 'Penggaris 100cm', 'satuan' => 'Buah', 'harga' => 33000],
            ['id_kodering' => 5, 'nama_barang' => 'Pensil 2B', 'satuan' => 'Pack', 'harga' => 55610],
            ['id_kodering' => 5, 'nama_barang' => 'Penghapus Karet', 'satuan' => 'Box', 'harga' => 60244],
            ['id_kodering' => 5, 'nama_barang' => 'Staples Ukuran Besar', 'satuan' => 'Buah', 'harga' => 19750],
            ['id_kodering' => 5, 'nama_barang' => 'Staples Ukuran Kecil', 'satuan' => 'Buah', 'harga' => 9500],
            ['id_kodering' => 5, 'nama_barang' => 'Isi Staples Uk Kecil', 'satuan' => 'Box', 'harga' => 4635],
            ['id_kodering' => 5, 'nama_barang' => 'Isi Staples Uk Besar', 'satuan' => 'Box', 'harga' => 9681],
            ['id_kodering' => 5, 'nama_barang' => 'Lem Kertas Cair', 'satuan' => 'Box', 'harga' => 8000],
            ['id_kodering' => 5, 'nama_barang' => 'Cutter Uk Sedang', 'satuan' => 'Buah', 'harga' => 12400],
            ['id_kodering' => 5, 'nama_barang' => 'Penanda Warna/Highlighter', 'satuan' => 'Lusin', 'harga' => 23500],
            ['id_kodering' => 5, 'nama_barang' => 'Map Dinas Full Warna Bufalo', 'satuan' => 'Lembar', 'harga' => 16000],
            ['id_kodering' => 5, 'nama_barang' => 'Balllpoint gel spek Uk 0.5/0.7 mm', 'satuan' => 'Lusin', 'harga' => 76800],
            ['id_kodering' => 5, 'nama_barang' => 'Map Expanding file (Tas Map)', 'satuan' => 'Buah', 'harga' => 47900],
            ['id_kodering' => 5, 'nama_barang' => 'Ordner dan Map (Map Plastik Snelhekter)', 'satuan' => 'Buah', 'harga' => 7200],
            ['id_kodering' => 5, 'nama_barang' => 'Tipe X Cair', 'satuan' => 'Buah', 'harga' => 5100],
            ['id_kodering' => 6, 'nama_barang' => 'Kertas HVS F4 70 Gram', 'satuan' => 'Rim', 'harga' => 52458],
            ['id_kodering' => 6, 'nama_barang' => 'Kertas HVS A4 70 Gram', 'satuan' => 'Rim', 'harga' => 52458],
            ['id_kodering' => 6, 'nama_barang' => 'Kertas F4/A4 Warna', 'satuan' => 'Rim', 'harga' => 119221],
            ['id_kodering' => 7, 'nama_barang' => 'Map Dinas Fullcolour', 'satuan' => 'Buah', 'harga' => 8800],
            ['id_kodering' => 7, 'nama_barang' => 'Tone Refill Mesin Fotocopy', 'satuan' => 'Buah', 'harga' => 103300],
            ['id_kodering' => 9, 'nama_barang' => 'Tinta Warna Mesin Printer', 'satuan' => 'Buah', 'harga' => 413200],
            ['id_kodering' => 9, 'nama_barang' => 'Tinta Printer Epson 664 Hitam', 'satuan' => 'Buah', 'harga' => 126260],
            ['id_kodering' => 9, 'nama_barang' => 'Tinta Printer Epson 664 Cyan', 'satuan' => 'Buah', 'harga' => 105000],
            ['id_kodering' => 9, 'nama_barang' => 'Tinta Printer Epson 664 Magenta', 'satuan' => 'Buah', 'harga' => 105000],
            ['id_kodering' => 9, 'nama_barang' => 'Tinta Printer Epson 664 Yellow', 'satuan' => 'Buah', 'harga' => 105000],
            ['id_kodering' => 9, 'nama_barang' => 'Tinta/Toner Printer Epson 003 Yellow', 'satuan' => 'Buah', 'harga' => 123000],
            ['id_kodering' => 9, 'nama_barang' => 'Tinta/toner Printer Epson 003 Black', 'satuan' => 'Buah', 'harga' => 123000],
            ['id_kodering' => 9, 'nama_barang' => 'Tinta/Toner Printer Epson 003 Cyan', 'satuan' => 'Buah', 'harga' => 123000],
            ['id_kodering' => 9, 'nama_barang' => 'Tinta/Toner Printer Epson 003 Magenta', 'satuan' => 'Buah', 'harga' => 123000],
            ['id_kodering' => 10, 'nama_barang' => 'Refill Spray Pewangi/Ecocare LCD', 'satuan' => 'Buah', 'harga' => 48049],
            ['id_kodering' => 10, 'nama_barang' => 'Refill Spray Pewangi/Ecocare LCD', 'satuan' => 'Buah', 'harga' => 48034],
            ['id_kodering' => 10, 'nama_barang' => 'Tissue Kering Kotak', 'satuan' => 'Buah', 'harga' => 29659],
            ['id_kodering' => 10, 'nama_barang' => 'Tissue Roll/Toilet', 'satuan' => 'Pack', 'harga' => 21771],
            ['id_kodering' => 10, 'nama_barang' => 'Cairan pembersih lantai 800 ml', 'satuan' => 'Botol', 'harga' => 36750],
            ['id_kodering' => 10, 'nama_barang' => 'kamper', 'satuan' => 'Botol', 'harga' => 30450],
            ['id_kodering' => 10, 'nama_barang' => 'Pembersih Kaca Spray', 'satuan' => 'Pack', 'harga' => 17000],
            ['id_kodering' => 10, 'nama_barang' => 'Keset Anti Slip', 'satuan' => 'Buah', 'harga' => 51388],
            ['id_kodering' => 10, 'nama_barang' => 'Mop Pel Set', 'satuan' => 'Buah', 'harga' => 262500],
            ['id_kodering' => 10, 'nama_barang' => 'Sapu dan Pengki', 'satuan' => 'Buah', 'harga' => 67385],
            ['id_kodering' => 10, 'nama_barang' => 'Lap Kanebo', 'satuan' => 'Pack', 'harga' => 26851],
            ['id_kodering' => 10, 'nama_barang' => 'Sabun Cuci Tangan', 'satuan' => 'Liter', 'harga' => 38103],
            ['id_kodering' => 10, 'nama_barang' => 'Gunting Rumput', 'satuan' => 'Buah', 'harga' => 150000],
            ['id_kodering' => 10, 'nama_barang' => 'Tempat Sampah Terpilah', 'satuan' => 'Set', 'harga' => 1295875],
            ['id_kodering' => 10, 'nama_barang' => 'Sabun Cuci Piring', 'satuan' => 'Pack', 'harga' => 30450],
            ['id_kodering' => 10, 'nama_barang' => 'Sikat WC', 'satuan' => 'Buah', 'harga' => 73500],
            ['id_kodering' => 18, 'nama_barang' => 'Gula Pasir 1 Kg', 'satuan' => 'PACK', 'harga' => 19975],
            ['id_kodering' => 18, 'nama_barang' => 'Teh Celup Sachet/Box Kecil', 'satuan' => 'PACK', 'harga' => 14825],
            ['id_kodering' => 18, 'nama_barang' => 'Kopi Bubuk 100 Gram', 'satuan' => 'PACK', 'harga' => 105460],
            ['id_kodering' => 18, 'nama_barang' => 'Mie Instan Isi 40 Bungkus', 'satuan' => 'DUS', 'harga' => 157202],
            ['id_kodering' => 18, 'nama_barang' => 'Air Mineral Galon', 'satuan' => 'GALON', 'harga' => 29700],
            ['id_kodering' => 18, 'nama_barang' => 'Biskuit Kaleng', 'satuan' => 'KALENG', 'harga' => 70496],
            ['id_kodering' => 20, 'nama_barang' => 'Nasi Kotak', 'satuan' => 'BOX', 'harga' => 45000],
            ['id_kodering' => 20, 'nama_barang' => 'Snack', 'satuan' => 'BOX', 'harga' => 20000],
            ['id_kodering' => 20, 'nama_barang' => 'Nasi Kotak', 'satuan' => 'BOX', 'harga' => 35000],
            ['id_kodering' => 20, 'nama_barang' => 'Snack', 'satuan' => 'BOX', 'harga' => 20000],
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
