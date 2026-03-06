<?php

namespace App\Models;

use CodeIgniter\Model;

class HargaBarangModel extends Model
{
    protected $table            = 'harga_barang';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['id_barang', 'harga_beli', 'dibuat_pada'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'dibuat_pada';
    protected $updatedField  = '';
}
