<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'parent_id'  => '0',
                'title'      => 'Dashboard',
                'icon'       => 'fas fa-tachometer-alt',
                'route'      => 'dashboard',
                'sequence'   => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'parent_id'  => '0',
                'title'      => 'User Management',
                'icon'       => 'fas fa-user',
                'route'      => '#',
                'sequence'   => '2',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'parent_id'  => '2',
                'title'      => 'User Profile',
                'icon'       => 'fas fa-user-edit',
                'route'      => 'user-management/profile',
                'sequence'   => '3',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'parent_id'  => '2',
                'title'      => 'Users',
                'icon'       => 'fas fa-users',
                'route'      => 'user-management/users',
                'sequence'   => '4',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'parent_id'  => '2',
                'title'      => 'Permissions',
                'icon'       => 'fas fa-user-lock',
                'route'      => 'user-management/permissions',
                'sequence'   => '5',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'parent_id'  => '2',
                'title'      => 'Roles',
                'icon'       => 'fas fa-users-cog',
                'route'      => 'user-management/roles',
                'sequence'   => '6',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'parent_id'  => '2',
                'title'      => 'Menu',
                'icon'       => 'fas fa-stream',
                'route'      => 'user-management/menus/list',
                'sequence'   => '7',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        foreach ($data as $menu) {
            // Check if the record exists based on a unique field (e.g., title)
            $existingMenu = $this->db->table('menu')->where('title', $menu['title'])->get()->getRow();

            if ($existingMenu) {
                // Update the existing record
                $this->db->table('menu')->where('id', $existingMenu->id)->update($menu);
            } else {
                // Insert a new record
                $this->db->table('menu')->insert($menu);
            }
        }
    }
}
