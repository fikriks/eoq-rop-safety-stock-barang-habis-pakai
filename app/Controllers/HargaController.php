<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\HargaBarangModel;

class HargaController extends BaseController
{
    protected $barangModel;
    protected $hargaModel;

    public function __construct()
    {
        $this->barangModel = new BarangModel();
        $this->hargaModel = new HargaBarangModel();
    }

    public function index()
    {
        $data = [
            'barang' => $this->barangModel->findAll(),
        ];
        return view('harga/index', $data);
    }

    public function detail($id_barang)
    {
        $barang = $this->barangModel->find($id_barang);
        if (!$barang) return redirect()->to('/harga')->with('error', 'Barang tidak ditemukan.');

        $data = [
            'barang' => $barang,
            'riwayat_harga' => $this->hargaModel->where('id_barang', $id_barang)
                                                ->orderBy('id', 'DESC')
                                                ->findAll()
        ];
        return view('harga/detail', $data);
    }

    public function simpan()
    {
        $id_barang = $this->request->getPost('id_barang');
        $data = [
            'id_barang'   => $id_barang,
            'harga_beli'  => $this->request->getPost('harga_beli'),
        ];

        if ($this->hargaModel->save($data)) {
            return redirect()->to('/harga/detail/' . $id_barang)->with('success', 'Harga baru berhasil ditambahkan.');
        }
        return redirect()->back()->with('error', 'Gagal menambahkan harga.');
    }

    public function hapus($id)
    {
        $harga = $this->hargaModel->find($id);
        if (!$harga) return redirect()->back()->with('error', 'Data tidak ditemukan.');

        $id_barang = $harga['id_barang'];
        
        // Cek apakah ini satu-satunya harga (jangan biarkan barang tanpa record harga)
        $count = $this->hargaModel->where('id_barang', $id_barang)->countAllResults();
        if ($count <= 1) {
            return redirect()->back()->with('error', 'Gagal! Barang harus memiliki setidaknya satu data harga.');
        }

        if ($this->hargaModel->delete($id)) {
            return redirect()->to('/harga/detail/' . $id_barang)->with('success', 'Data harga berhasil dihapus.');
        }
        return redirect()->back()->with('error', 'Gagal menghapus data harga.');
    }
}
