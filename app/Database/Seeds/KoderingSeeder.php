<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KoderingSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['kode_rekening' => '5.1.02.01.01.0001', 'nama_rekening' => 'Bahan-Bahan Bangunan dan Konstruksi'],
            ['kode_rekening' => '5.1.02.01.01.0004', 'nama_rekening' => 'Bahan-Bahan Bakar dan Pelumas'],
            ['kode_rekening' => '5.1.02.01.01.0010', 'nama_rekening' => 'Bahan-Isi Tabung Gas'],
            ['kode_rekening' => '5.1.02.01.01.0012', 'nama_rekening' => 'Bahan-Bahan Lainnya'],
            ['kode_rekening' => '5.1.02.01.01.0024', 'nama_rekening' => 'Alat/Bahan untuk Kegiatan Kantor-Alat Tulis Kantor'],
            ['kode_rekening' => '5.1.02.01.01.0025', 'nama_rekening' => 'Alat/Bahan untuk Kegiatan Kantor-Kertas dan Cover'],
            ['kode_rekening' => '5.1.02.01.01.0026', 'nama_rekening' => 'Alat/Bahan untuk Kegiatan Kantor-Bahan Cetak'],
            ['kode_rekening' => '5.1.02.01.01.0027', 'nama_rekening' => 'Alat/Bahan untuk Kegiatan Kantor-Benda Pos'],
            ['kode_rekening' => '5.1.02.01.01.0029', 'nama_rekening' => 'Alat/Bahan untuk Kegiatan Kantor-Bahan Komputer'],
            ['kode_rekening' => '5.1.02.01.01.0030', 'nama_rekening' => 'Alat/Bahan untuk Kegiatan Kantor-Perabot Kantor (Perabot kantor, Termasuk Bahan Kebersihan)'],
            ['kode_rekening' => '5.1.02.01.01.0031', 'nama_rekening' => 'Alat/Bahan untuk Kegiatan Kanto Alat Listrik'],
            ['kode_rekening' => '5.1.02.01.01.0032', 'nama_rekening' => 'Alat/Bahan untuk Kegiatan Kantor-Perlengkapan Dinas'],
            ['kode_rekening' => '5.1.02.01.01.0034', 'nama_rekening' => 'Alat/Bahan untuk Kegiatan Kantor-Perlengkapan Pendukung Olahraga'],
            ['kode_rekening' => '5.1.02.01.01.0035', 'nama_rekening' => 'Alat/Bahan untuk Kegiatan Kantor Suvenir/Cendera Mata'],
            ['kode_rekening' => '5.1.02.01.01.0036', 'nama_rekening' => 'Alat/Bahan untuk Kegiatan Kantor-Alat/Bahan untuk Kegiatan Kantor Lainnya'],
            ['kode_rekening' => '5.1.02.01.01.0037', 'nama_rekening' => 'Obat-Obatan'],
            ['kode_rekening' => '5.1.02.01.01.0038', 'nama_rekening' => 'Obat-Obatan-Obat-Obatan Lainnya'],
            ['kode_rekening' => '5.1.02.01.01.0043', 'nama_rekening' => 'Natura dan Pakan-Natura'],
            ['kode_rekening' => '5.1.02.01.01.0044', 'nama_rekening' => 'Belanja Natura dan Pakan-Pakan'],
            ['kode_rekening' => '5.1.02.01.01.0052', 'nama_rekening' => 'Makanan dan Minuman Rapat'],
            ['kode_rekening' => '5.1.02.01.01.0053', 'nama_rekening' => 'Belanja Makanan dan Minuman Jamuan Tamu'],
            ['kode_rekening' => '5.1.02.01.01.0055', 'nama_rekening' => 'Belanja Makanan dan Minuman pada Fasilitas Pelayanan Urusan Pendidikan'],
            ['kode_rekening' => '5.1.02.01.01.0064', 'nama_rekening' => 'Belanja Pakaian Dinas Lapangan (PDL)'],
            ['kode_rekening' => '5.1.02.01.01.0076', 'nama_rekening' => 'Belanja Pakaian Olahraga'],
        ];

        // Tambahkan timestamps
        foreach ($data as &$row) {
            $row['dibuat_pada'] = date('Y-m-d H:i:s');
            $row['diperbarui_pada'] = date('Y-m-d H:i:s');
        }

        $this->db->table('kodering')->insertBatch($data);
    }
}
