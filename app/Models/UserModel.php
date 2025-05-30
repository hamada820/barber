<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id_user';

    // Tambahkan 'is_active' ke allowedFields
    protected $allowedFields = [
        'username', 'number', 'email', 'password', 'role', 'RegDate', 'is_active'
    ];

    protected $useTimestamps = false; // Tidak wajib true, kecuali kamu pakai created_at/updated_at
}
