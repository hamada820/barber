<?php

namespace App\Models;

use CodeIgniter\Model;

class ServiceModel extends Model
{
    protected $table            = 'tblservices';
    protected $primaryKey       = 'id_service';
    protected $allowedFields    = ['ServiceName', 'ServiceDescription', 'Cost', 'Image','Bookable','CreationDate'];
    protected $useTimestamps    = false; // atau true jika menggunakan created_at
}
