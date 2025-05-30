<?php

namespace App\Models;

use CodeIgniter\Model;

class EmailVerificationModel extends Model
{
    protected $table = 'email_verifications';
    protected $allowedFields = ['email', 'token', 'created_at'];
    public $timestamps = false;
}
