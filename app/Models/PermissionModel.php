<?php

namespace App\Models;

use CodeIgniter\Model;

class PermissionModel extends Model
{
    protected $table = 'auth_permissions';  // Tabel permissions di Myth/Auth
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description'];  // Kolom yang bisa diisi
}