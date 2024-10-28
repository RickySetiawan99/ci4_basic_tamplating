<?php

namespace App\Database\Seeds;

use CodeIgniter\Config\Services;
use CodeIgniter\Database\Seeder;
use Myth\Auth\Models\UserModel;

class AuthPermissionsSeeder extends Seeder
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
        $data = [
            [
                'name'       => 'dashboard-read',
                'description'=> 'null',
                'module_id'  => 1,
            ],
            [
                'name'       => 'user-read',
                'description'=> 'null',
                'module_id'  => 4,
            ],
            [
                'name'       => 'user-create',
                'description'=> 'null',
                'module_id'  => 4,
            ],
            [
                'name'       => 'user-update',
                'description'=> 'null',
                'module_id'  => 4,
            ],
            [
                'name'       => 'user-delete',
                'description'=> 'null',
                'module_id'  => 4,
            ],
            [
                'name'       => 'permission-read',
                'description'=> 'null',
                'module_id'  => 5,
            ],
            [
                'name'       => 'permission-create',
                'description'=> 'null',
                'module_id'  => 5,
            ],
            [
                'name'       => 'permission-update',
                'description'=> 'null',
                'module_id'  => 5,
            ],
            [
                'name'       => 'permission-delete',
                'description'=> 'null',
                'module_id'  => 5,
            ],
            [
                'name'       => 'role-read',
                'description'=> 'null',
                'module_id'  => 6,
            ],
            [
                'name'       => 'role-create',
                'description'=> 'null',
                'module_id'  => 6,
            ],
            [
                'name'       => 'role-update',
                'description'=> 'null',
                'module_id'  => 6,
            ],
            [
                'name'       => 'role-delete',
                'description'=> 'null',
                'module_id'  => 6,
            ],
            [
                'name'       => 'menu-read',
                'description'=> 'null',
                'module_id'  => 7,
            ],
            [
                'name'       => 'menu-create',
                'description'=> 'null',
                'module_id'  => 7,
            ],
            [
                'name'       => 'menu-update',
                'description'=> 'null',
                'module_id'  => 7,
            ],
            [
                'name'       => 'menu-delete',
                'description'=> 'null',
                'module_id'  => 7,
            ],
        ];

        foreach ($data as $permission) {
            $existingPermission = $this->db->table('auth_permissions')
                    ->where('name', $permission['name'])
                    ->get()
                    ->getRow();

            if ($existingPermission) {
                $this->db->table('auth_permissions')->where('id', $existingPermission->id)->update([
                    'module_id' => $permission['module_id'],
                ]);
            } else {
                $this->db->table('auth_permissions')->insert([
                    'name' => $permission['name'],
                    'module_id' => $permission['module_id'],
                ]);
            }

            $this->addPermissionToGroup($permission['name'], 'admin');
        }
    }

    public function down()
    {
        $permissions = $this->db->table('auth_permissions')->select('name')->get()->getResultArray();
        foreach ($permissions as $permission) {
            // Remove the permission
            $this->db->table('auth_permissions')->where('name', $permission['name'])->delete();
        }
    }

    protected function addPermissionToGroup($permissionName, $groupName)
    {
        // Mendapatkan ID permission berdasarkan nama
        $permission = $this->db->table('auth_permissions')->where('name', $permissionName)->get()->getRow();

        if ($permission) {
            $permissionId = $permission->id;

            // Mendapatkan ID grup berdasarkan nama
            $group = $this->db->table('auth_groups')->where('name', $groupName)->get()->getRow();

            if ($group) {
                $groupId = $group->id;

                // Cek apakah permission sudah ada di grup ini
                $existing = $this->db->table('auth_groups_permissions')
                    ->where(['group_id' => $groupId, 'permission_id' => $permissionId])
                    ->get()
                    ->getRow();

                if (!$existing) {
                    // Jika permission belum ada di grup, tambahkan ke grup
                    $this->db->table('auth_groups_permissions')->insert([
                        'group_id' => $groupId,
                        'permission_id' => $permissionId,
                        // 'created_at' => date('Y-m-d H:i:s'),
                    ]);
                }
            } else {
                throw new \Exception("Group with name '{$groupName}' not found.");
            }
        } else {
            throw new \Exception("Permission with name '{$permissionName}' not found.");
        }
    }
}
