<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportExcel extends BaseCommand
{
    protected $group = 'App';
    protected $name = 'export:excel';
    protected $description = 'Export data barang, transaksi masuk, dan transaksi keluar ke template excel';
    protected $usage = 'export:excel';

    public function run(array $params)
    {
        $db = \Config\Database::connect();
        $exportDir = ROOTPATH . 'public/exports/';
        if (!is_dir($exportDir)) {
            mkdir($exportDir, 0777, true);
        }

        // ==========================================
        // 1. Export Data Barang
        // ==========================================
        CLI::write('Exporting data barang...', 'yellow');
        $spreadsheetBarang = new Spreadsheet();
        $sheetBarang = $spreadsheetBarang->getActiveSheet();

        // Header
        $sheetBarang->setCellValue('A1', 'Nama Barang');
        $sheetBarang->setCellValue('B1', 'Kode Rekening (Kodering)');
        $sheetBarang->setCellValue('C1', 'Satuan');
        $sheetBarang->setCellValue('D1', 'Harga Beli Awal');
        $sheetBarang->setCellValue('E1', 'Stok Awal');

        $barang = $db->table('barang')
                     ->select('barang.*, kodering.kode_rekening')
                     ->join('kodering', 'kodering.id = barang.id_kodering')
                     ->orderBy('barang.id', 'ASC')
                     ->get()
                     ->getResultArray();

        $rowIdx = 2;
        foreach ($barang as $b) {
            // Ambil Harga Beli Awal
            $hargaRecord = $db->table('harga_barang')
                              ->where('id_barang', $b['id'])
                              ->orderBy('id', 'ASC')
                              ->get()
                              ->getRowArray();
            $hargaAwal = $hargaRecord ? $hargaRecord['harga_beli'] : 0;

            // Ambil Stok Awal (transaksi awal Jan 2025)
            $stokAwal = 0;
            $awalTx = $db->table('transaksi')
                         ->where('id_barang', $b['id'])
                         ->where('keterangan', 'Stok Awal Januari 2025')
                         ->get()
                         ->getRowArray();
            if ($awalTx) {
                $stokAwal = $awalTx['jumlah'];
            }

            $sheetBarang->setCellValue('A' . $rowIdx, $b['nama_barang']);
            $sheetBarang->setCellValue('B' . $rowIdx, $b['kode_rekening']);
            $sheetBarang->setCellValue('C' . $rowIdx, $b['satuan']);
            $sheetBarang->setCellValue('D' . $rowIdx, $hargaAwal);
            $sheetBarang->setCellValue('E' . $rowIdx, $stokAwal);
            $rowIdx++;
        }

        $writerBarang = new Xlsx($spreadsheetBarang);
        $writerBarang->save($exportDir . 'data_barang.xlsx');
        CLI::write('Data barang exported to: public/exports/data_barang.xlsx', 'green');

        // ==========================================
        // 2. Export Transaksi Masuk
        // ==========================================
        CLI::write('Exporting transaksi masuk...', 'yellow');
        $spreadsheetMasuk = new Spreadsheet();
        $sheetMasuk = $spreadsheetMasuk->getActiveSheet();

        // Header
        $sheetMasuk->setCellValue('A1', 'Nama Barang');
        $sheetMasuk->setCellValue('B1', 'Nama Supplier');
        $sheetMasuk->setCellValue('C1', 'Jumlah');
        $sheetMasuk->setCellValue('D1', 'Harga Beli');
        $sheetMasuk->setCellValue('E1', 'Tanggal (YYYY-MM-DD)');
        $sheetMasuk->setCellValue('F1', 'Keterangan');

        $transaksiMasuk = $db->table('transaksi')
                             ->select('transaksi.*, barang.nama_barang, supplier.nama_supplier, harga_barang.harga_beli')
                             ->join('barang', 'barang.id = transaksi.id_barang')
                             ->join('supplier', 'supplier.id = transaksi.id_supplier', 'left')
                             ->join('harga_barang', 'harga_barang.id = transaksi.id_harga', 'left')
                             ->where('transaksi.tipe', 'MASUK')
                             ->orderBy('transaksi.tgl_transaksi', 'ASC')
                             ->get()
                             ->getResultArray();

        $rowIdx = 2;
        foreach ($transaksiMasuk as $tx) {
            $sheetMasuk->setCellValue('A' . $rowIdx, $tx['nama_barang']);
            $sheetMasuk->setCellValue('B' . $rowIdx, $tx['nama_supplier'] ?? '');
            $sheetMasuk->setCellValue('C' . $rowIdx, $tx['jumlah']);
            $sheetMasuk->setCellValue('D' . $rowIdx, $tx['harga_beli'] ?? 0);
            $sheetMasuk->setCellValue('E' . $rowIdx, $tx['tgl_transaksi']);
            $sheetMasuk->setCellValue('F' . $rowIdx, $tx['keterangan']);
            $rowIdx++;
        }

        $writerMasuk = new Xlsx($spreadsheetMasuk);
        $writerMasuk->save($exportDir . 'transaksi_masuk.xlsx');
        CLI::write('Transaksi masuk exported to: public/exports/transaksi_masuk.xlsx', 'green');

        // ==========================================
        // 3. Export Transaksi Keluar
        // ==========================================
        CLI::write('Exporting transaksi keluar...', 'yellow');
        $spreadsheetKeluar = new Spreadsheet();
        $sheetKeluar = $spreadsheetKeluar->getActiveSheet();

        // Header
        $sheetKeluar->setCellValue('A1', 'Nama Barang');
        $sheetKeluar->setCellValue('B1', 'Jumlah');
        $sheetKeluar->setCellValue('C1', 'Tanggal (YYYY-MM-DD)');
        $sheetKeluar->setCellValue('D1', 'Keterangan / Penerima');

        $transaksiKeluar = $db->table('transaksi')
                              ->select('transaksi.*, barang.nama_barang')
                              ->join('barang', 'barang.id = transaksi.id_barang')
                              ->where('transaksi.tipe', 'KELUAR')
                              ->orderBy('transaksi.tgl_transaksi', 'ASC')
                              ->get()
                              ->getResultArray();

        $rowIdx = 2;
        foreach ($transaksiKeluar as $tx) {
            $sheetKeluar->setCellValue('A' . $rowIdx, $tx['nama_barang']);
            $sheetKeluar->setCellValue('B' . $rowIdx, $tx['jumlah']);
            $sheetKeluar->setCellValue('C' . $rowIdx, $tx['tgl_transaksi']);
            $sheetKeluar->setCellValue('D' . $rowIdx, $tx['keterangan']);
            $rowIdx++;
        }

        $writerKeluar = new Xlsx($spreadsheetKeluar);
        $writerKeluar->save($exportDir . 'transaksi_keluar.xlsx');
        CLI::write('Transaksi keluar exported to: public/exports/transaksi_keluar.xlsx', 'green');

        CLI::write('All files exported successfully!', 'green');
    }
}
