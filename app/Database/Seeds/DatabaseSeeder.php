<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(GroupMenuSeeder::class);
        $this->call(AuthPermissionModulesSeeder::class);
        $this->call(AuthPermissionsSeeder::class);
    }
}
