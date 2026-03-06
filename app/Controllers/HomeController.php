<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\TransaksiModel;
use App\Models\AnalisisStokModel;

class HomeController extends BaseController
{
    public function index(): string
    {
        $barangModel = new BarangModel();
        $transaksiModel = new TransaksiModel();
        $analisisModel = new AnalisisStokModel();

        // 1. Hitung Stok Rendah
        $stokRendah = $barangModel->join('analisis_stok', 'analisis_stok.id_barang = barang.id')
                                  ->where('barang.stok <= analisis_stok.rop')
                                  ->countAllResults();

        // 2. Hitung Transaksi Hari Ini
        $transaksiHariIni = $transaksiModel->where('tgl_transaksi', date('Y-m-d'))->countAllResults();

        // 3. Total Jenis Barang
        $totalBarang = $barangModel->countAllResults();

        // 4. Data Notifikasi Stok Kritis
        $notifikasi = $barangModel->select('barang.nama_barang, barang.stok, analisis_stok.rop')
                                  ->join('analisis_stok', 'analisis_stok.id_barang = barang.id')
                                  ->where('barang.stok <= analisis_stok.rop')
                                  ->limit(5)
                                  ->findAll();

        // 5. Data Grafik (6 Bulan Terakhir)
        $chartLabels = [];
        $chartData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-$i months"));
            $monthLabel = date('M', strtotime("-$i months"));
            
            $total = $transaksiModel->where('tipe', 'KELUAR')
                                    ->like('tgl_transaksi', $month, 'after')
                                    ->selectSum('jumlah')
                                    ->first();
            
            $chartLabels[] = $monthLabel;
            $chartData[] = (int)($total['jumlah'] ?? 0);
        }

        $data = [
            'countStokRendah' => $stokRendah,
            'countTransaksi'  => $transaksiHariIni,
            'countTotalBarang'=> $totalBarang,
            'notifikasi'      => $notifikasi,
            'chartLabels'     => json_encode($chartLabels),
            'chartData'       => json_encode($chartData)
        ];

        return view('dashboard', $data);
    }
}
