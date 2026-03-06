<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\AnalisisStokModel;
use App\Models\TransaksiModel;
use App\Models\HargaBarangModel;

class AnalisisController extends BaseController
{
    protected $barangModel;
    protected $analisisModel;
    protected $transaksiModel;
    protected $hargaModel;

    public function __construct()
    {
        $this->barangModel = new BarangModel();
        $this->analisisModel = new AnalisisStokModel();
        $this->transaksiModel = new TransaksiModel();
        $this->hargaModel = new HargaBarangModel();
    }

    public function index()
    {
        $barang = $this->barangModel->select('barang.*, kodering.nama_rekening, analisis_stok.eoq, analisis_stok.rop, analisis_stok.stok_pengaman, analisis_stok.terakhir_dihitung_pada')
                                    ->join('kodering', 'kodering.id = barang.id_kodering')
                                    ->join('analisis_stok', 'analisis_stok.id_barang = barang.id', 'left')
                                    ->findAll();

        foreach ($barang as &$item) {
            $hargaTerbaru = $this->hargaModel->where('id_barang', $item['id'])
                                              ->orderBy('id', 'DESC')
                                              ->first();
            $item['harga_referensi'] = $hargaTerbaru ? $hargaTerbaru['harga_beli'] : 0;
        }

        $data = ['barang' => $barang];
        return view('analisis/index', $data);
    }

    public function hitung($id_barang)
    {
        $barang = $this->barangModel->select('barang.*, kodering.nama_rekening')
                                    ->join('kodering', 'kodering.id = barang.id_kodering')
                                    ->find($id_barang);
        
        if (!$barang) return redirect()->to('/analisis')->with('error', 'Barang tidak ditemukan.');

        $oneYearAgo = date('Y-m-d', strtotime('-1 year'));
        $totalKeluarTahun = $this->transaksiModel->where('id_barang', $id_barang)
                                                 ->where('tipe', 'KELUAR')
                                                 ->where('tgl_transaksi >=', $oneYearAgo)
                                                 ->selectSum('jumlah')
                                                 ->first();
        $suggested_D = $totalKeluarTahun['jumlah'] ?? 0;

        $hargaTerbaru = $this->hargaModel->where('id_barang', $id_barang)
                                         ->orderBy('id', 'DESC')
                                         ->first();
        $unitPrice = $hargaTerbaru ? $hargaTerbaru['harga_beli'] : 0;
        $suggested_H = $unitPrice * 0.1;

        $suggested_d_avg = $suggested_D / 365;

        $maxKeluar = $this->transaksiModel->where('id_barang', $id_barang)
                                          ->where('tipe', 'KELUAR')
                                          ->selectMax('jumlah')
                                          ->first();
        $suggested_d_max = $maxKeluar['jumlah'] ?? 0;

        $data = [
            'barang'   => $barang,
            'analisis' => $this->analisisModel->where('id_barang', $id_barang)->first(),
            'unitPrice'=> $unitPrice,
            'suggested' => [
                'D'      => $suggested_D,
                'H'      => $suggested_H,
                'd_avg'  => round($suggested_d_avg, 2),
                'd_max'  => $suggested_d_max,
                'S'      => 50000,
                'lt_avg' => 3,
                'lt_max' => 7
            ]
        ];
        return view('analisis/hitung', $data);
    }

    public function simpan()
    {
        $id_barang = $this->request->getPost('id_barang');
        
        $D = (float) $this->request->getPost('permintaan_tahunan');
        $S = (float) $this->request->getPost('biaya_pemesanan');
        $H = (float) $this->request->getPost('biaya_penyimpanan');
        
        $lt_avg = (float) $this->request->getPost('waktu_tunggu');
        $lt_max = (float) $this->request->getPost('waktu_tunggu_maksimum');
        $d_avg  = (float) $this->request->getPost('permintaan_rata_rata');
        $d_max  = (float) $this->request->getPost('permintaan_maksimum');

        $eoq = ($H > 0) ? sqrt((2 * $D * $S) / $H) : 0;
        $safety_stock = ($d_max * $lt_max) - ($d_avg * $lt_avg);
        $rop = ($lt_avg * $d_avg) + $safety_stock;

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

        $existing = $this->analisisModel->where('id_barang', $id_barang)->first();

        if ($existing) {
            $this->analisisModel->update($existing['id'], $data_simpan);
        } else {
            $this->analisisModel->insert($data_simpan);
        }

        return redirect()->to('/analisis')->with('success', 'Analisis berhasil dihitung!');
    }
}
