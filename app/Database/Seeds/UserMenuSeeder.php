<?php

namespace App\Database\Seeds;

use App\Entities\User;
use CodeIgniter\Config\Services;
use CodeIgniter\Database\Seeder;
use Myth\Auth\Models\UserModel;

class UserMenuSeeder extends Seeder
{
    /**
     * @var Authorize
     */
    protected $authorize;

    /**
     * @var Db
     */
    protected $db;

    /**
     * @var Users
     */
    protected $users;

    public function __construct()
    {
        $this->authorize = Services::authorization();
        $this->db = \Config\Database::connect();
        $this->users = new UserModel();
    }

    public function run()
    {
        // User
        $this->users->save(new User([
            'email'    => 'admin@admin.com',
            'username' => 'admin',
            'password' => 'super-admin',
            'active'   => '1',
        ]));

        $this->users->save(new User([
            'email'    => 'user@user.com',
            'username' => 'user',
            'password' => 'super-user',
            'active'   => '1',
        ]));

        // Role
        $this->authorize->createGroup('admin', 'Administrators. The top of the food chain.');
        $this->authorize->createGroup('user', 'User everyday user.');

        // // Permission
        $this->authorize->createPermission('user-read');
        $this->authorize->createPermission('user-create');
        $this->authorize->createPermission('user-update');
        $this->authorize->createPermission('user-delete');
        $this->authorize->createPermission('menu-read');
        $this->authorize->createPermission('menu-create');
        $this->authorize->createPermission('menu-update');
        $this->authorize->createPermission('menu-delete');
        $this->authorize->createPermission('permission-read');
        $this->authorize->createPermission('permission-create');
        $this->authorize->createPermission('permission-update');
        $this->authorize->createPermission('permission-delete');
        $this->authorize->createPermission('role-read');
        $this->authorize->createPermission('role-create');
        $this->authorize->createPermission('role-update');
        $this->authorize->createPermission('role-delete');
        
        // Assign Permission to role
        $this->authorize->addPermissionToGroup('user-read', 'admin');
        $this->authorize->addPermissionToGroup('user-create', 'admin');
        $this->authorize->addPermissionToGroup('user-update', 'admin');
        $this->authorize->addPermissionToGroup('user-delete', 'admin');
        $this->authorize->addPermissionToGroup('menu-read', 'admin');
        $this->authorize->addPermissionToGroup('menu-create', 'admin');
        $this->authorize->addPermissionToGroup('menu-update', 'admin');
        $this->authorize->addPermissionToGroup('menu-delete', 'admin');
        $this->authorize->addPermissionToGroup('permission-read', 'admin');
        $this->authorize->addPermissionToGroup('permission-create', 'admin');
        $this->authorize->addPermissionToGroup('permission-update', 'admin');
        $this->authorize->addPermissionToGroup('permission-delete', 'admin');
        $this->authorize->addPermissionToGroup('role-read', 'admin');
        $this->authorize->addPermissionToGroup('role-create', 'admin');
        $this->authorize->addPermissionToGroup('role-update', 'admin');
        $this->authorize->addPermissionToGroup('role-delete', 'admin');

        // Assign Role to user
        $this->authorize->addUserToGroup(1, 'admin');
        $this->authorize->addUserToGroup(1, 'user');
        $this->authorize->addUserToGroup(2, 'user');

        // Assign Permission to user
        // $this->authorize->addPermissionToUser('back-office', 1);
        // $this->authorize->addPermissionToUser('manage-user', 1);
        // $this->authorize->addPermissionToUser('role-permission', 1);
        // $this->authorize->addPermissionToUser('menu-permission', 1);
        // $this->authorize->addPermissionToUser('back-office', 2);

        $this->db->table('menu')->insertBatch([
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
                'route'      => 'user-management/menus',
                'sequence'   => '7',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);

        $this->db->table('groups_menu')->insertBatch([
            [
                'group_id' => 1,
                'menu_id'  => 1,
            ],
            [
                'group_id' => 1,
                'menu_id'  => 2,
            ],
            [
                'group_id' => 1,
                'menu_id'  => 3,
            ],
            [
                'group_id' => 1,
                'menu_id'  => 4,
            ],
            [
                'group_id' => 1,
                'menu_id'  => 5,
            ],
            [
                'group_id' => 1,
                'menu_id'  => 6,
            ],
            [
                'group_id' => 1,
                'menu_id'  => 7,
            ],
            [
                'group_id' => 2,
                'menu_id'  => 1,
            ],
            [
                'group_id' => 2,
                'menu_id'  => 2,
            ],
            [
                'group_id' => 2,
                'menu_id'  => 3,
            ],
        ]);
    }

    public function down()
    {
        //
    }
}
