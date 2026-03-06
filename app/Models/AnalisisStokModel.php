<?php

namespace App\Models;

use CodeIgniter\Model;

class AnalisisStokModel extends Model
{
    protected $table            = 'analisis_stok';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'id_barang', 
        'permintaan_tahunan', 
        'biaya_pemesanan', 
        'biaya_penyimpanan', 
        'waktu_tunggu', 
        'permintaan_maksimum', 
        'permintaan_rata_rata', 
        'waktu_tunggu_maksimum', 
        'eoq', 
        'stok_pengaman', 
        'rop', 
        'terakhir_dihitung_pada'
    ];

    // Dates
    protected $useTimestamps = false; // We use terakhir_dihitung_pada manually if needed
}
