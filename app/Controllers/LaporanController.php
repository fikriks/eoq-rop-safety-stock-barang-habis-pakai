<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\TransaksiModel;

class LaporanController extends BaseController
{
    protected $barangModel;
    protected $transaksiModel;

    public function __construct()
    {
        $this->barangModel = new BarangModel();
        $this->transaksiModel = new TransaksiModel();
    }

    public function stok()
    {
        $data = [
            'barang' => $this->barangModel->select('barang.*, kodering.kode_rekening, kodering.nama_rekening')
                                          ->join('kodering', 'kodering.id = barang.id_kodering')
                                          ->findAll(),
        ];
        return view('laporan/stok', $data);
    }

    public function transaksi()
    {
        $tgl_mulai = $this->request->getGet('tgl_mulai') ?? date('Y-m-01');
        $tgl_selesai = $this->request->getGet('tgl_selesai') ?? date('Y-m-d');

        $data = [
            'transaksi' => $this->transaksiModel->select('transaksi.*, barang.nama_barang, pengguna.nama_pengguna, harga_barang.harga_beli, supplier.nama_supplier')
                                              ->join('barang', 'barang.id = transaksi.id_barang')
                                              ->join('pengguna', 'pengguna.id = transaksi.id_pengguna')
                                              ->join('harga_barang', 'harga_barang.id = transaksi.id_harga', 'left')
                                              ->join('supplier', 'supplier.id = transaksi.id_supplier', 'left')
                                              ->where('tgl_transaksi >=', $tgl_mulai)
                                              ->where('tgl_transaksi <=', $tgl_selesai)
                                              ->orderBy('tgl_transaksi', 'DESC')
                                              ->findAll(),
            'tgl_mulai' => $tgl_mulai,
            'tgl_selesai' => $tgl_selesai
        ];
        return view('laporan/transaksi', $data);
    }
}
