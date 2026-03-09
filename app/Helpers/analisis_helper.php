<?php

use App\Models\AnalisisStokModel;
use App\Models\TransaksiModel;
use App\Models\HargaBarangModel;

if (!function_exists('hitung_ulang_analisis')) {
    function hitung_ulang_analisis($id_barang, $target_bulan = null, $target_tahun = null)
    {
        $analisisModel = new AnalisisStokModel();
        $transaksiModel = new TransaksiModel();
        $hargaModel = new HargaBarangModel();

        if (!$target_bulan) {
            $target_bulan = (int)date('m');
            $target_tahun = (int)date('Y');
        }

        // Tentukan rentang historis: 12 bulan terakhir sebelum bulan target
        // Jika target Maret 2026, maka data diambil dari Maret 2025 s/d Februari 2026
        $targetDateStr = "$target_tahun-" . str_pad($target_bulan, 2, '0', STR_PAD_LEFT) . "-01";
        $endDate = date('Y-m-t', strtotime("$targetDateStr -1 month"));
        $startDate = date('Y-m-d', strtotime("$endDate -1 year +1 day"));
        
        // 1. Ambil Total Permintaan (D)
        $resD = $transaksiModel->where('id_barang', $id_barang)
                               ->where('tipe', 'KELUAR')
                               ->where('tgl_transaksi >=', $startDate)
                               ->where('tgl_transaksi <=', $endDate)
                               ->selectSum('jumlah')
                               ->first();
        
        $totalDemand = (float)($resD['jumlah'] ?? 0);

        // FALLBACK: Jika data historis kosong di periode tersebut, coba ambil semua data yang ada
        // agar tidak tampil 0 (untuk testing/seeder baru)
        if ($totalDemand <= 0) {
            $resD = $transaksiModel->where('id_barang', $id_barang)
                                   ->where('tipe', 'KELUAR')
                                   ->selectSum('jumlah')
                                   ->first();
            $totalDemand = (float)($resD['jumlah'] ?? 0);
        }

        $D_month = $totalDemand / 12;
        $d_avg_day = $totalDemand / 365;

        // 2. Hitung Standar Deviasi Harian Riil
        // Ambil penggunaan per hari dalam rentang tersebut
        $allTransactions = $transaksiModel->where('id_barang', $id_barang)
                                          ->where('tipe', 'KELUAR')
                                          ->where('tgl_transaksi >=', $startDate)
                                          ->where('tgl_transaksi <=', $endDate)
                                          ->select('tgl_transaksi, SUM(jumlah) as daily_total')
                                          ->groupBy('tgl_transaksi')
                                          ->findAll();

        $dailyMap = [];
        foreach ($allTransactions as $t) {
            $dailyMap[$t['tgl_transaksi']] = (float)$t['daily_total'];
        }

        // Hitung varians dari 365 hari
        $variance = 0;
        for ($i = 0; $i < 365; $i++) {
            $checkDate = date('Y-m-d', strtotime("$startDate +$i days"));
            $usage = $dailyMap[$checkDate] ?? 0;
            $variance += pow($usage - $d_avg_day, 2);
        }
        $std_dev_day = sqrt($variance / 365);

        // 3. Harga & Biaya Simpan
        $hargaTerbaru = $hargaModel->where('id_barang', $id_barang)
                                   ->where('dibuat_pada <=', $endDate . ' 23:59:59')
                                   ->orderBy('id', 'DESC')
                                   ->first();
        // Fallback harga jika tidak ditemukan di rentang tersebut
        if (!$hargaTerbaru) $hargaTerbaru = $hargaModel->where('id_barang', $id_barang)->orderBy('id', 'DESC')->first();
        
        $unitPrice = (float)($hargaTerbaru ? $hargaTerbaru['harga_beli'] : 0);
        $H_month = ($unitPrice * 0.1) / 12; // 10% per tahun / 12

        // 4. Parameter
        $S = 50000;       
        $lt_avg = 3; 
        $Z = 1.65; 

        // 5. Rumus Final
        $eoq = ($H_month > 0) ? sqrt((2 * $D_month * $S) / $H_month) : 0;
        $safety_stock = $Z * $std_dev_day * sqrt($lt_avg);
        $rop = ($lt_avg * $d_avg_day) + $safety_stock;

        // 6. Simpan
        $data_simpan = [
            'id_barang'             => $id_barang,
            'bulan'                 => $target_bulan,
            'tahun'                 => $target_tahun,
            'permintaan_tahunan'    => $D_month,
            'biaya_pemesanan'       => $S,
            'biaya_penyimpanan'     => $H_month,
            'waktu_tunggu'          => $lt_avg,
            'permintaan_rata_rata'  => $d_avg_day,
            'eoq'                   => $eoq,
            'stok_pengaman'         => $safety_stock,
            'rop'                   => $rop,
            'terakhir_dihitung_pada' => date('Y-m-d H:i:s')
        ];

        $existing = $analisisModel->where('id_barang', $id_barang)
                                  ->where('bulan', $target_bulan)
                                  ->where('tahun', $target_tahun)
                                  ->first();
                                  
        if ($existing) {
            $analisisModel->update($existing['id'], $data_simpan);
        } else {
            $analisisModel->insert($data_simpan);
        }

        return true;
    }
}
