<?php

namespace App\Controllers;

use App\Models\AnalisisStokModel;
use App\Models\BarangModel;

class AnalisisController extends BaseController
{
    protected $analisisModel;
    protected $barangModel;

    public function __construct()
    {
        $this->analisisModel = new AnalisisStokModel();
        $this->barangModel = new BarangModel();
    }

    public function index()
    {
        helper('analisis');

        // Filter periode (Default: Bulan depan)
        $bulan = $this->request->getGet('bulan') ?: (int)date('m', strtotime('+1 month'));
        $tahun = $this->request->getGet('tahun') ?: (int)date('Y', strtotime('+1 month'));

        $allBarang = $this->barangModel->findAll();

        foreach ($allBarang as $b) {
            // Cek apakah sudah ada analisis untuk periode ini
            $exists = $this->analisisModel->where('id_barang', $b['id'])
                                          ->where('bulan', $bulan)
                                          ->where('tahun', $tahun)
                                          ->first();
            
            // Jika belum ada, hitung otomatis
            if (!$exists) {
                hitung_ulang_analisis($b['id'], $bulan, $tahun);
            }
        }

        $data = [
            'bulan'  => $bulan,
            'tahun'  => $tahun,
            'barang' => $this->barangModel->select('barang.*, kodering.nama_rekening, 
                                            analisis_stok.permintaan_tahunan, analisis_stok.biaya_pemesanan, 
                                            analisis_stok.biaya_penyimpanan, analisis_stok.waktu_tunggu, 
                                            analisis_stok.permintaan_rata_rata, analisis_stok.eoq, 
                                            analisis_stok.stok_pengaman, analisis_stok.rop, 
                                            analisis_stok.terakhir_dihitung_pada')
                                          ->join('kodering', 'kodering.id = barang.id_kodering')
                                          ->join('analisis_stok', "analisis_stok.id_barang = barang.id AND analisis_stok.bulan = $bulan AND analisis_stok.tahun = $tahun", 'left')
                                          ->findAll()
        ];

        return view('analisis/index', $data);
    }

    public function hitung($id)
    {
        helper('analisis');
        $bulan = $this->request->getGet('bulan') ?: (int)date('m', strtotime('+1 month'));
        $tahun = $this->request->getGet('tahun') ?: (int)date('Y', strtotime('+1 month'));

        hitung_ulang_analisis($id, $bulan, $tahun);
        return redirect()->to("/analisis?bulan=$bulan&tahun=$tahun")->with('success', 'Analisis berhasil diperbarui.');
    }
}
