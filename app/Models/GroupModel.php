<?php

namespace App\Models;

use Myth\Auth\Models\GroupModel as ModelsGroupModel;

class GroupModel extends ModelsGroupModel
{
    protected $validationRules = [
        'name'        => 'required|max_length[255]|is_unique[auth_groups.name,id,{id}]', // Modifikasi aturan validasi
        'description' => 'max_length[255]',
    ];
}
