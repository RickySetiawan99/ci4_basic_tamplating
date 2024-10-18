<?php

namespace App\Models;

use Myth\Auth\Models\PermissionModel as ModelsPermissionModel;

class PermissionModel extends ModelsPermissionModel
{
    protected $validationRules = [
        'name'        => 'required|max_length[255]|is_unique[auth_permissions.name,id,{id}]', // Modifikasi aturan validasi
        'description' => 'max_length[255]',
    ];
}