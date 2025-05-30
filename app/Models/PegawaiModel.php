<?php

namespace App\Models;

use CodeIgniter\Model;

class PegawaiModel extends Model
{
    protected $table = 'tblpegawai';
    protected $primaryKey = 'id_pegawai';
    protected $allowedFields = ['nama', 'alamat', 'telepon', 'image', 'id_user'];
}
