<?php

namespace App\Models;

use CodeIgniter\Model;

class PageModel extends Model
{
    protected $table = 'tblpage';
    protected $primaryKey = 'ID'; // Sesuaikan jika berbeda
    protected $allowedFields = ['PageType', 'PageTitle', 'PageDescription'];
}
