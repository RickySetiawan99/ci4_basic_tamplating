<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFieldModuleIdTablesAuthPermissions extends Migration
{
    public function up()
    {
        $this->forge->addColumn('auth_permissions', [
            'module_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
            ],
        ]);

        $this->forge->addForeignKey('module_id', 'auth_permission_modules', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->forge->dropForeignKey('auth_permissions', 'auth_permissions_module_id_foreign');
        $this->forge->dropColumn('auth_permissions', 'module_id');
    }
}
