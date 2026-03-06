<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\KoderingModel;
use App\Models\HargaBarangModel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class BarangController extends BaseController
{
    protected $barangModel;
    protected $koderingModel;
    protected $hargaModel;

    public function __construct()
    {
        $this->barangModel = new BarangModel();
        $this->koderingModel = new KoderingModel();
        $this->hargaModel = new HargaBarangModel();
    }

    public function index()
    {
        $barang = $this->barangModel->select('barang.*, kodering.kode_rekening, kodering.nama_rekening')
                                    ->join('kodering', 'kodering.id = barang.id_kodering')
                                    ->findAll();

        foreach ($barang as &$item) {
            $harga_terbaru = $this->hargaModel->where('id_barang', $item['id'])
                                              ->orderBy('id', 'DESC')
                                              ->first();
            $item['harga_terbaru'] = $harga_terbaru ? $harga_terbaru['harga_beli'] : 0;
        }

        $data = [
            'barang' => $barang,
            'kodering' => $this->koderingModel->findAll(),
        ];
        return view('barang/index', $data);
    }

    public function simpan()
    {
        helper('analisis');
        $db = \Config\Database::connect();
        $db->transStart();

        $id_barang = $this->barangModel->insert([
            'id_kodering' => $this->request->getPost('id_kodering'),
            'nama_barang' => $this->request->getPost('nama_barang'),
            'satuan'      => $this->request->getPost('satuan'),
            'stok'        => $this->request->getPost('stok') ?? 0,
        ]);

        $this->hargaModel->save([
            'id_barang'   => $id_barang,
            'harga_beli'  => $this->request->getPost('harga_beli'),
        ]);

        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            return redirect()->to('/barang')->with('error', 'Gagal menambahkan barang.');
        }

        hitung_ulang_analisis($id_barang);
        return redirect()->to('/barang')->with('success', 'Barang berhasil ditambahkan!');
    }

    public function import()
    {
        helper('analisis');
        $file = $this->request->getFile('file_excel');

        if (!$file->isValid() || $file->getExtension() !== 'xlsx') {
            return redirect()->back()->with('error', 'Format file harus .xlsx');
        }

        $spreadsheet = IOFactory::load($file->getTempName());
        $data = $spreadsheet->getActiveSheet()->toArray();

        $db = \Config\Database::connect();
        $successCount = 0;
        $errors = [];

        foreach ($data as $index => $row) {
            if ($index == 0) continue; // Skip header

            $nama_barang = $row[0];
            $kode_rekening = $row[1];
            $satuan = $row[2];
            $harga_awal = $row[3];
            $stok_awal = $row[4];

            if (empty($nama_barang) || empty($kode_rekening)) continue;

            // Cari ID Kodering berdasarkan Kode Rekening
            $kodering = $this->koderingModel->where('kode_rekening', $kode_rekening)->first();
            if (!$kodering) {
                $errors[] = "Baris " . ($index + 1) . ": Kodering $kode_rekening tidak ditemukan.";
                continue;
            }

            $db->transStart();
            $id_barang = $this->barangModel->insert([
                'id_kodering' => $kodering['id'],
                'nama_barang' => $nama_barang,
                'satuan'      => $satuan,
                'stok'        => $stok_awal,
            ]);

            $this->hargaModel->insert([
                'id_barang'  => $id_barang,
                'harga_beli' => $harga_awal
            ]);
            $db->transComplete();

            if ($db->transStatus() !== FALSE) {
                hitung_ulang_analisis($id_barang);
                $successCount++;
            }
        }

        if (!empty($errors)) {
            return redirect()->to('/barang')->with('success', "Import selesai. $successCount barang berhasil.")
                                            ->with('error', implode('<br>', $errors));
        }

        return redirect()->to('/barang')->with('success', "Berhasil mengimport $successCount data barang.");
    }

    public function ubah()
    {
        $id = $this->request->getPost('id');
        $data = [
            'id_kodering' => $this->request->getPost('id_kodering'),
            'nama_barang' => $this->request->getPost('nama_barang'),
            'satuan'      => $this->request->getPost('satuan'),
        ];

        if ($this->barangModel->update($id, $data)) {
            return redirect()->to('/barang')->with('success', 'Barang berhasil diperbarui!');
        }
        return redirect()->to('/barang')->with('error', 'Gagal memperbarui barang.');
    }

    public function hapus($id)
    {
        try {
            if ($this->barangModel->delete($id)) {
                return redirect()->to('/barang')->with('success', 'Barang berhasil dihapus!');
            }
        } catch (\Exception $e) {
            return redirect()->to('/barang')->with('error', 'Gagal menghapus barang. Barang mungkin memiliki riwayat transaksi.');
        }
        return redirect()->to('/barang')->with('error', 'Gagal menghapus barang.');
    }
}
