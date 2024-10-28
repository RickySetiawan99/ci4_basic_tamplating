<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GroupMenuSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['group_id' => 1, 'menu_id' => 1],
            ['group_id' => 1, 'menu_id' => 2],
            ['group_id' => 1, 'menu_id' => 3],
            ['group_id' => 1, 'menu_id' => 4],
            ['group_id' => 1, 'menu_id' => 5],
            ['group_id' => 1, 'menu_id' => 6],
            ['group_id' => 1, 'menu_id' => 7],
            ['group_id' => 2, 'menu_id' => 1],
            ['group_id' => 2, 'menu_id' => 2],
            ['group_id' => 2, 'menu_id' => 3],
        ];

        foreach ($data as $item) {
            // Check if the record exists based on group_id and menu_id
            $existing = $this->db->table('groups_menu')
                ->where('group_id', $item['group_id'])
                ->where('menu_id', $item['menu_id'])
                ->get()
                ->getRow();

            if ($existing) {
                // Update the existing record if necessary
                $this->db->table('groups_menu')->where('id', $existing->id)->update($item);
            } else {
                // Insert a new record if it does not exist
                $this->db->table('groups_menu')->insert($item);
            }
        }
    }
}
