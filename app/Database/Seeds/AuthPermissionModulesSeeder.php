<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AuthPermissionModulesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'menu_id'     => 1,
                'created_by'  => 1,
                'updated_by'  => 1,
                // 'created_at'  => date('Y-m-d H:i:s'),
                // 'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'menu_id'     => 3,
                'created_by'  => 1,
                'updated_by'  => 1,
                // 'created_at'  => date('Y-m-d H:i:s'),
                // 'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'menu_id'     => 4,
                'created_by'  => 1,
                'updated_by'  => 1,
                // 'created_at'  => date('Y-m-d H:i:s'),
                // 'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'menu_id'     => 5,
                'created_by'  => 1,
                'updated_by'  => 1,
                // 'created_at'  => date('Y-m-d H:i:s'),
                // 'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'menu_id'     => 6,
                'created_by'  => 1,
                'updated_by'  => 1,
                // 'created_at'  => date('Y-m-d H:i:s'),
                // 'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'menu_id'     => 7,
                'created_by'  => 1,
                'updated_by'  => 1,
                // 'created_at'  => date('Y-m-d H:i:s'),
                // 'updated_at'  => date('Y-m-d H:i:s'),
            ],
        ];

        foreach ($data as $item) {
            // Check if the record exists based on menu_id
            $existing = $this->db->table('auth_permission_modules')
                ->where('menu_id', $item['menu_id'])
                ->get()
                ->getRow();

            if ($existing) {
                // Update the existing record if necessary
                $this->db->table('auth_permission_modules')->where('menu_id', $item['menu_id'])->update($item);
            } else {
                // Insert a new record if it does not exist
                $this->db->table('auth_permission_modules')->insert($item);
            }
        }
    }
}
