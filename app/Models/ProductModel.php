<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'tblproduk';
    protected $primaryKey       = 'id_produk';
    protected $allowedFields    = ['nama_produk', 'deskripsi', 'harga', 'stok', 'Image'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
}

