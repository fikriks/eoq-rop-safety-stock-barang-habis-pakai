<?php

namespace App\Controllers;

use App\Models\TransaksiModel;
use App\Models\BarangModel;
use App\Models\HargaBarangModel;
use App\Models\SupplierModel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class TransaksiController extends BaseController
{
    protected $transaksiModel;
    protected $barangModel;
    protected $hargaModel;
    protected $supplierModel;

    public function __construct()
    {
        $this->transaksiModel = new TransaksiModel();
        $this->barangModel = new BarangModel();
        $this->hargaModel = new HargaBarangModel();
        $this->supplierModel = new SupplierModel();
    }

    public function masuk()
    {
        $tgl_mulai = $this->request->getGet('tgl_mulai');
        $tgl_selesai = $this->request->getGet('tgl_selesai');

        $query = $this->transaksiModel->select('transaksi.*, barang.nama_barang, pengguna.nama_pengguna, harga_barang.harga_beli, supplier.nama_supplier')
                                      ->join('barang', 'barang.id = transaksi.id_barang')
                                      ->join('pengguna', 'pengguna.id = transaksi.id_pengguna')
                                      ->join('harga_barang', 'harga_barang.id = transaksi.id_harga', 'left')
                                      ->join('supplier', 'supplier.id = transaksi.id_supplier', 'left')
                                      ->where('tipe', 'MASUK');

        if ($tgl_mulai) $query->where('tgl_transaksi >=', $tgl_mulai);
        if ($tgl_selesai) $query->where('tgl_transaksi <=', $tgl_selesai);

        $data = [
            'transaksi'     => $query->orderBy('tgl_transaksi', 'DESC')->paginate(10),
            'pager'         => $this->transaksiModel->pager,
            'barang'        => $this->barangModel->findAll(),
            'supplier_list' => $this->supplierModel->findAll(),
            'tgl_mulai'     => $tgl_mulai,
            'tgl_selesai'   => $tgl_selesai
        ];

        return view('transaksi/masuk', $data);
    }

    public function keluar()
    {
        $tgl_mulai = $this->request->getGet('tgl_mulai');
        $tgl_selesai = $this->request->getGet('tgl_selesai');

        $query = $this->transaksiModel->select('transaksi.*, barang.nama_barang, pengguna.nama_pengguna')
                                      ->join('barang', 'barang.id = transaksi.id_barang')
                                      ->join('pengguna', 'pengguna.id = transaksi.id_pengguna')
                                      ->where('tipe', 'KELUAR');

        if ($tgl_mulai) $query->where('tgl_transaksi >=', $tgl_mulai);
        if ($tgl_selesai) $query->where('tgl_transaksi <=', $tgl_selesai);

        $data = [
            'transaksi'     => $query->orderBy('tgl_transaksi', 'DESC')->paginate(10),
            'pager'         => $this->transaksiModel->pager,
            'barang'        => $this->barangModel->findAll(),
            'tgl_mulai'     => $tgl_mulai,
            'tgl_selesai'   => $tgl_selesai
        ];

        return view('transaksi/keluar', $data);
    }

    public function simpan()
    {
        helper('analisis');
        $tipe = $this->request->getPost('tipe');
        $id_barang = $this->request->getPost('id_barang');
        $id_supplier = $this->request->getPost('id_supplier');
        $jumlah = $this->request->getPost('jumlah');
        $harga_input = $this->request->getPost('harga_beli');

        $db = \Config\Database::connect();
        $db->transStart();

        $id_harga = null;
        if ($tipe == 'MASUK') {
            $id_harga = $this->hargaModel->insert([
                'id_barang'   => $id_barang,
                'harga_beli'  => $harga_input,
            ]);
        } else {
            $harga_terakhir = $this->hargaModel->where('id_barang', $id_barang)->orderBy('id', 'DESC')->first();
            $id_harga = $harga_terakhir ? $harga_terakhir['id'] : null;
        }

        $this->transaksiModel->save([
            'id_barang'     => $id_barang,
            'id_pengguna'   => session()->get('id'),
            'id_harga'      => $id_harga,
            'id_supplier'   => ($tipe == 'MASUK') ? $id_supplier : null,
            'tipe'          => $tipe,
            'jumlah'        => $jumlah,
            'keterangan'    => $this->request->getPost('keterangan'),
            'tgl_transaksi' => $this->request->getPost('tgl_transaksi'),
        ]);

        $barang = $this->barangModel->find($id_barang);
        $stok_baru = ($tipe == 'MASUK') ? $barang['stok'] + $jumlah : $barang['stok'] - $jumlah;

        if ($tipe == 'KELUAR' && $stok_baru < 0) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Gagal! Stok barang tidak mencukupi.');
        }

        $this->barangModel->update($id_barang, ['stok' => $stok_baru]);
        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan transaksi.');
        }

        hitung_ulang_analisis($id_barang);
        $redirect_path = ($tipe == 'MASUK') ? '/transaksi/masuk' : '/transaksi/keluar';
        return redirect()->to($redirect_path)->with('success', 'Transaksi berhasil dicatat!');
    }

    public function import_masuk()
    {
        helper('analisis');
        $file = $this->request->getFile('file_excel');
        if (!$file->isValid() || $file->getExtension() !== 'xlsx') return redirect()->back()->with('error', 'Format file harus .xlsx');

        $spreadsheet = IOFactory::load($file->getTempName());
        $rows = $spreadsheet->getActiveSheet()->toArray();

        $db = \Config\Database::connect();
        $successCount = 0; $errors = [];

        foreach ($rows as $index => $row) {
            if ($index == 0) continue;
            $nama_barang = $row[0]; $nama_supplier = $row[1]; $jumlah = $row[2]; $harga = $row[3]; $tanggal = $row[4]; $ket = $row[5];

            if (empty($nama_barang)) continue;

            $barang = $this->barangModel->where('nama_barang', $nama_barang)->first();
            $supplier = $this->supplierModel->where('nama_supplier', $nama_supplier)->first();

            if (!$barang) { $errors[] = "Brs " . ($index+1) . ": Barang '$nama_barang' tdk ada."; continue; }
            if (!$supplier) { $errors[] = "Brs " . ($index+1) . ": Supplier '$nama_supplier' tdk ada."; continue; }

            $db->transStart();
            $id_harga = $this->hargaModel->insert(['id_barang' => $barang['id'], 'harga_beli' => $harga]);
            $this->transaksiModel->insert([
                'id_barang' => $barang['id'], 'id_pengguna' => session()->get('id'), 'id_harga' => $id_harga,
                'id_supplier' => $supplier['id'], 'tipe' => 'MASUK', 'jumlah' => $jumlah, 'tgl_transaksi' => $tanggal, 'keterangan' => $ket
            ]);
            $this->barangModel->update($barang['id'], ['stok' => $barang['stok'] + $jumlah]);
            $db->transComplete();

            if ($db->transStatus() !== FALSE) { hitung_ulang_analisis($barang['id']); $successCount++; }
        }
        return redirect()->to('/transaksi/masuk')->with('success', "Import selesai. $successCount berhasil.")->with('error', implode('<br>', $errors));
    }

    public function import_keluar()
    {
        helper('analisis');
        $file = $this->request->getFile('file_excel');
        if (!$file->isValid() || $file->getExtension() !== 'xlsx') return redirect()->back()->with('error', 'Format file harus .xlsx');

        $spreadsheet = IOFactory::load($file->getTempName());
        $rows = $spreadsheet->getActiveSheet()->toArray();

        $db = \Config\Database::connect();
        $successCount = 0; $errors = [];

        foreach ($rows as $index => $row) {
            if ($index == 0) continue;
            $nama_barang = $row[0]; $jumlah = $row[1]; $tanggal = $row[2]; $ket = $row[3];

            if (empty($nama_barang)) continue;

            $barang = $this->barangModel->where('nama_barang', $nama_barang)->first();
            if (!$barang) { $errors[] = "Brs " . ($index+1) . ": Barang '$nama_barang' tdk ada."; continue; }
            if ($barang['stok'] < $jumlah) { $errors[] = "Brs " . ($index+1) . ": Stok '$nama_barang' tdk cukup."; continue; }

            $db->transStart();
            $harga_terakhir = $this->hargaModel->where('id_barang', $barang['id'])->orderBy('id', 'DESC')->first();
            $this->transaksiModel->insert([
                'id_barang' => $barang['id'], 'id_pengguna' => session()->get('id'), 'id_harga' => $harga_terakhir ? $harga_terakhir['id'] : null,
                'tipe' => 'KELUAR', 'jumlah' => $jumlah, 'tgl_transaksi' => $tanggal, 'keterangan' => $ket
            ]);
            $this->barangModel->update($barang['id'], ['stok' => $barang['stok'] - $jumlah]);
            $db->transComplete();

            if ($db->transStatus() !== FALSE) { hitung_ulang_analisis($barang['id']); $successCount++; }
        }
        return redirect()->to('/transaksi/keluar')->with('success', "Import selesai. $successCount berhasil.")->with('error', implode('<br>', $errors));
    }

    public function hapus($id)
    {
        helper('analisis');
        $transaksi = $this->transaksiModel->find($id);
        if (!$transaksi) return redirect()->back()->with('error', 'Data tidak ditemukan.');

        $db = \Config\Database::connect();
        $db->transStart();
        $barang = $this->barangModel->find($transaksi['id_barang']);
        $stok_revert = ($transaksi['tipe'] == 'MASUK') ? $barang['stok'] - $transaksi['jumlah'] : $barang['stok'] + $transaksi['jumlah'];
        if ($stok_revert < 0) { $db->transRollback(); return redirect()->back()->with('error', 'Gagal! Stok negatif.'); }

        $this->barangModel->update($transaksi['id_barang'], ['stok' => $stok_revert]);
        if ($transaksi['tipe'] == 'MASUK' && $transaksi['id_harga']) $this->hargaModel->delete($transaksi['id_harga']);
        $this->transaksiModel->delete($id);
        $db->transComplete();

        if ($db->transStatus() !== FALSE) hitung_ulang_analisis($transaksi['id_barang']);
        return redirect()->back()->with('success', 'Berhasil dihapus.');
    }
}
