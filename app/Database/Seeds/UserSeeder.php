<?php

namespace App\Database\Seeds;

use App\Entities\User;
use CodeIgniter\Config\Services;
use CodeIgniter\Database\Seeder;
use Myth\Auth\Models\UserModel;

class UserSeeder extends Seeder
{
    protected $authorize;
    protected $db;
    protected $users;

    public function __construct()
    {
        $this->authorize = Services::authorization();
        $this->db = \Config\Database::connect();
        $this->users = new UserModel();
    }

    public function run()
    {
        // Membuat pengguna
        $adminId = $this->createOrUpdateUser([
            'email'    => 'admin@admin.com',
            'username' => 'admin',
            'password' => 'super-admin',
            'active'   => '1',
        ]);

        $userId = $this->createOrUpdateUser([
            'email'    => 'user@user.com',
            'username' => 'user',
            'password' => 'super-user',
            'active'   => '1',
        ]);

        // Membuat grup
        $this->createOrUpdateGroup('admin', 'Administrators. The top of the food chain.');
        $this->createOrUpdateGroup('user', 'User everyday user.');

        // Menambahkan pengguna ke grup
        $this->addUserToGroup($adminId, 'admin');
        $this->addUserToGroup($adminId, 'user');
        $this->addUserToGroup($userId, 'user');
    }

    protected function createOrUpdateUser(array $data)
    {
        // Cek apakah user sudah ada berdasarkan email
        $existingUser = $this->users->where('email', $data['email'])->first();

        if ($existingUser) {
            return $existingUser->id;
        }

        $this->users->save(new User($data));
        return $this->users->getInsertID();
    }

    protected function createOrUpdateGroup(string $name, string $description)
    {
        // Cek apakah grup sudah ada
        if (!$this->authorize->group($name)) {
            $this->authorize->createGroup($name, $description);
        }
    }

    protected function addUserToGroup($userId, $groupName)
    {
        // Mendapatkan ID grup berdasarkan nama grup
        $group = $this->db->table('auth_groups')->where('name', $groupName)->get()->getRow();

        if ($group) {
            $groupId = $group->id;

            // Cek apakah user sudah ada di grup ini
            $existing = $this->db->table('auth_groups_users')
                ->where(['user_id' => $userId, 'group_id' => $groupId])
                ->get()
                ->getRow();

            if (!$existing) {
                // Tambahkan user ke grup jika belum ada
                $this->db->table('auth_groups_users')->insert([
                    'user_id' => $userId,
                    'group_id' => $groupId,
                ]);
            }
        } else {
            throw new \Exception("Group with name '{$groupName}' not found.");
        }
    }
}
