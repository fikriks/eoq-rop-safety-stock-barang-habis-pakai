<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    public function run()
    {
        helper('analisis');
        $db = \Config\Database::connect();
        $barang = $db->table('barang')->get()->getResultArray();
        $users = [1, 2];
        $suppliers = [1, 2, 3];

        $dataTransaksi = [];
        $currentDate = new \DateTime();
        $startDate = (clone $currentDate)->modify('-6 months');

        foreach ($barang as $b) {
            $tempDate = clone $startDate;
            $runningStok = 0;

            // 1. Ambil Harga Awal dari Seeder Barang
            $hargaRecord = $db->table('harga_barang')->where('id_barang', $b['id'])->orderBy('id', 'ASC')->get()->getRowArray();
            $current_id_harga = $hargaRecord['id'];
            $current_harga_beli = (float)$hargaRecord['harga_beli'];

            // Initial Stock (MASUK)
            $initialQty = rand(100, 300);
            $runningStok += $initialQty;
            
            $dataTransaksi[] = [
                'id_barang'     => $b['id'],
                'id_pengguna'   => 1,
                'id_harga'      => $current_id_harga,
                'id_supplier'   => $suppliers[array_rand($suppliers)],
                'tipe'          => 'MASUK',
                'jumlah'        => $initialQty,
                'keterangan'    => 'Stok Awal Semester',
                'tgl_transaksi' => $tempDate->format('Y-m-d'),
                'dibuat_pada'   => $tempDate->format('Y-m-d H:i:s'),
                'diperbarui_pada' => $tempDate->format('Y-m-d H:i:s'),
            ];

            // 2. Simulasi 6 Bulan
            while ($tempDate < $currentDate) {
                $tempDate->modify('+' . rand(1, 4) . ' days');
                if ($tempDate > $currentDate) break;

                $dice = rand(1, 10);
                
                if ($dice <= 8) { // 80% KELUAR
                    $qtyOut = rand(1, 15);
                    if ($runningStok >= $qtyOut) {
                        $runningStok -= $qtyOut;
                        $dataTransaksi[] = [
                            'id_barang'     => $b['id'],
                            'id_pengguna'   => $users[array_rand($users)],
                            'id_harga'      => $current_id_harga, // Pakai harga yang sedang berlaku
                            'id_supplier'   => null,
                            'tipe'          => 'KELUAR',
                            'jumlah'        => $qtyOut,
                            'keterangan'    => 'Penggunaan rutin kantor',
                            'tgl_transaksi' => $tempDate->format('Y-m-d'),
                            'dibuat_pada'   => $tempDate->format('Y-m-d H:i:s'),
                            'diperbarui_pada' => $tempDate->format('Y-m-d H:i:s'),
                        ];
                    }
                } else { // 20% MASUK (Restock)
                    // SIMULASI PERUBAHAN HARGA (30% peluang harga berubah saat restock)
                    if (rand(1, 10) <= 3) {
                        $changePercent = rand(-10, 15) / 100; // Harga bisa turun 10% atau naik 15%
                        $current_harga_beli = round($current_harga_beli * (1 + $changePercent));
                        
                        // Insert Record Harga Baru
                        $db->table('harga_barang')->insert([
                            'id_barang'   => $b['id'],
                            'harga_beli'  => $current_harga_beli,
                            'dibuat_pada' => $tempDate->format('Y-m-d H:i:s'),
                        ]);
                        $current_id_harga = $db->insertID();
                    }

                    $qtyIn = rand(50, 150);
                    $runningStok += $qtyIn;
                    $dataTransaksi[] = [
                        'id_barang'     => $b['id'],
                        'id_pengguna'   => 1,
                        'id_harga'      => $current_id_harga, // Pakai harga baru atau harga lama
                        'id_supplier'   => $suppliers[array_rand($suppliers)],
                        'tipe'          => 'MASUK',
                        'jumlah'        => $qtyIn,
                        'keterangan'    => 'Restock pengadaan berkala',
                        'tgl_transaksi' => $tempDate->format('Y-m-d'),
                        'dibuat_pada'   => $tempDate->format('Y-m-d H:i:s'),
                        'diperbarui_pada' => $tempDate->format('Y-m-d H:i:s'),
                    ];
                }
            }

            // Stok Kritis untuk beberapa item
            if (in_array($b['id'], [1, 3, 5])) {
                $runningStok = rand(1, 5);
            }

            $db->table('barang')->where('id', $b['id'])->update(['stok' => $runningStok]);
        }

        // Insert Transaksi
        $chunks = array_chunk($dataTransaksi, 100);
        foreach ($chunks as $chunk) {
            $db->table('transaksi')->insertBatch($chunk);
        }

        // Jalankan Analisis Otomatis
        foreach ($barang as $b) {
            hitung_ulang_analisis($b['id']);
        }
    }
}
