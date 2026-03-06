<?php

use App\Models\AnalisisStokModel;
use App\Models\TransaksiModel;
use App\Models\HargaBarangModel;

if (!function_exists('hitung_ulang_analisis')) {
    /**
     * Menghitung ulang EOQ, ROP, dan Safety Stock untuk satu barang tertentu
     * berdasarkan riwayat transaksi nyata.
     */
    function hitung_ulang_analisis($id_barang)
    {
        $analisisModel = new AnalisisStokModel();
        $transaksiModel = new TransaksiModel();
        $hargaModel = new HargaBarangModel();

        // 1. Ambil Data Historis (1 Tahun Terakhir)
        $oneYearAgo = date('Y-m-d', strtotime('-1 year'));
        
        // Permintaan Tahunan (D)
        $resD = $transaksiModel->where('id_barang', $id_barang)
                               ->where('tipe', 'KELUAR')
                               ->where('tgl_transaksi >=', $oneYearAgo)
                               ->selectSum('jumlah')
                               ->first();
        $D = (float)($resD['jumlah'] ?? 0);

        // Penggunaan Maksimum (d_max)
        $resMax = $transaksiModel->where('id_barang', $id_barang)
                                 ->where('tipe', 'KELUAR')
                                 ->selectMax('jumlah')
                                 ->first();
        $d_max = (float)($resMax['jumlah'] ?? 0);

        // Harga Terbaru untuk Biaya Penyimpanan (H)
        $hargaTerbaru = $hargaModel->where('id_barang', $id_barang)
                                   ->orderBy('id', 'DESC')
                                   ->first();
        $H = (float)($hargaTerbaru ? $hargaTerbaru['harga_beli'] * 0.1 : 0);

        // Konstanta Default
        $S = 50000; // Biaya Pesan Default
        $lt_avg = 3; // Lead Time Default
        $lt_max = 7; // Lead Time Max Default
        $d_avg = $D / 365;

        // 2. Rumus Analisis
        // EOQ = sqrt((2 * D * S) / H)
        $eoq = ($H > 0) ? sqrt((2 * $D * $S) / $H) : 0;
        
        // Safety Stock = (D_max * LT_max) - (D_avg * LT_avg)
        $safety_stock = ($d_max * $lt_max) - ($d_avg * $lt_avg);
        
        // ROP = (LT_avg * D_avg) + Safety Stock
        $rop = ($lt_avg * $d_avg) + $safety_stock;

        // 3. Simpan ke Database
        $data_simpan = [
            'id_barang'             => $id_barang,
            'permintaan_tahunan'    => $D,
            'biaya_pemesanan'       => $S,
            'biaya_penyimpanan'     => $H,
            'waktu_tunggu'          => $lt_avg,
            'waktu_tunggu_maksimum' => $lt_max,
            'permintaan_rata_rata'  => $d_avg,
            'permintaan_maksimum'   => $d_max,
            'eoq'                   => $eoq,
            'stok_pengaman'         => $safety_stock,
            'rop'                   => $rop,
            'terakhir_dihitung_pada' => date('Y-m-d H:i:s')
        ];

        $existing = $analisisModel->where('id_barang', $id_barang)->first();
        if ($existing) {
            $analisisModel->update($existing['id'], $data_simpan);
        } else {
            $analisisModel->insert($data_simpan);
        }

        return true;
    }
}
