<?php

namespace App\Models;

use CodeIgniter\Model;

class KoderingModel extends Model
{
    protected $table            = 'kodering';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['kode_rekening', 'nama_rekening', 'dibuat_pada', 'diperbarui_pada'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'dibuat_pada';
    protected $updatedField  = 'diperbarui_pada';
}
