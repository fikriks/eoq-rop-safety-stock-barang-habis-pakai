<?php

namespace App\Controllers;

use App\Models\SupplierModel;

class SupplierController extends BaseController
{
    protected $supplierModel;

    public function __construct()
    {
        $this->supplierModel = new SupplierModel();
    }

    public function index()
    {
        $data = [
            'supplier' => $this->supplierModel->findAll(),
        ];
        return view('supplier/index', $data);
    }

    public function simpan()
    {
        $data = [
            'nama_supplier' => $this->request->getPost('nama_supplier'),
        ];

        if ($this->supplierModel->save($data)) {
            return redirect()->to('/supplier')->with('success', 'Supplier berhasil ditambahkan.');
        }
        return redirect()->to('/supplier')->with('error', 'Gagal menambahkan supplier.');
    }

    public function ubah()
    {
        $id = $this->request->getPost('id');
        $data = [
            'nama_supplier' => $this->request->getPost('nama_supplier'),
        ];

        if ($this->supplierModel->update($id, $data)) {
            return redirect()->to('/supplier')->with('success', 'Supplier berhasil diperbarui.');
        }
        return redirect()->to('/supplier')->with('error', 'Gagal memperbarui supplier.');
    }

    public function hapus($id)
    {
        try {
            if ($this->supplierModel->delete($id)) {
                return redirect()->to('/supplier')->with('success', 'Supplier berhasil dihapus.');
            }
        } catch (\Exception $e) {
            return redirect()->to('/supplier')->with('error', 'Gagal menghapus! Supplier mungkin masih terhubung dengan data transaksi.');
        }
        return redirect()->to('/supplier')->with('error', 'Gagal menghapus supplier.');
    }
}
