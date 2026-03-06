<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class TemplateController extends BaseController
{
    public function barang()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Header
        $sheet->setCellValue('A1', 'Nama Barang');
        $sheet->setCellValue('B1', 'Kode Rekening (Kodering)');
        $sheet->setCellValue('C1', 'Satuan');
        $sheet->setCellValue('D1', 'Harga Beli Awal');
        $sheet->setCellValue('E1', 'Stok Awal');

        // Contoh Data
        $sheet->setCellValue('A2', 'Kertas A4 80gr');
        $sheet->setCellValue('B2', '5.1.02.01.01.0024');
        $sheet->setCellValue('C2', 'Rim');
        $sheet->setCellValue('D2', '55000');
        $sheet->setCellValue('E2', '10');

        $writer = new Xlsx($spreadsheet);
        $filename = 'template_barang.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $filename .'"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function transaksi_masuk()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Header
        $sheet->setCellValue('A1', 'Nama Barang');
        $sheet->setCellValue('B1', 'Nama Supplier');
        $sheet->setCellValue('C1', 'Jumlah');
        $sheet->setCellValue('D1', 'Harga Beli');
        $sheet->setCellValue('E1', 'Tanggal (YYYY-MM-DD)');
        $sheet->setCellValue('F1', 'Keterangan');

        // Contoh Data
        $sheet->setCellValue('A2', 'Kertas A4 80gr');
        $sheet->setCellValue('B2', 'CV. Maju Jaya ATK');
        $sheet->setCellValue('C2', '50');
        $sheet->setCellValue('D2', '56000');
        $sheet->setCellValue('E2', date('Y-m-d'));
        $sheet->setCellValue('F2', 'Pengadaan rutin');

        $writer = new Xlsx($spreadsheet);
        $filename = 'template_barang_masuk.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $filename .'"');
        $writer->save('php://output');
        exit;
    }

    public function transaksi_keluar()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Header
        $sheet->setCellValue('A1', 'Nama Barang');
        $sheet->setCellValue('B1', 'Jumlah');
        $sheet->setCellValue('C1', 'Tanggal (YYYY-MM-DD)');
        $sheet->setCellValue('D1', 'Keterangan / Penerima');

        // Contoh Data
        $sheet->setCellValue('A2', 'Kertas A4 80gr');
        $sheet->setCellValue('B2', '5');
        $sheet->setCellValue('C2', date('Y-m-d'));
        $sheet->setCellValue('D2', 'Digunakan Seksi Kurikulum');

        $writer = new Xlsx($spreadsheet);
        $filename = 'template_barang_keluar.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $filename .'"');
        $writer->save('php://output');
        exit;
    }
}
