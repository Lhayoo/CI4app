<?php

namespace App\Models;

use CodeIgniter\Model;

class orangModel extends Model
{
    protected $table = 'orang';
    protected $useTimestamps = true;
    protected $allowedFields = ['nama', 'alamat'];
}