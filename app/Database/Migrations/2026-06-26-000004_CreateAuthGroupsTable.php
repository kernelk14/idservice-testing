<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAuthGroupsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'title'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'description' => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('name');
        $this->forge->createTable('auth_groups', true);

        $groups = [
            ['name' => 'superadmin', 'title' => 'Super Admin', 'description' => 'Complete control of the site.'],
            ['name' => 'admin',      'title' => 'Admin',       'description' => 'Day to day administrators of the site.'],
            ['name' => 'developer',  'title' => 'Developer',   'description' => 'Site programmers.'],
            ['name' => 'user',       'title' => 'User',        'description' => 'General users of the site. Often customers.'],
            ['name' => 'beta',       'title' => 'Beta User',   'description' => 'Has access to beta-level features.'],
        ];

        $now = date('Y-m-d H:i:s');
        foreach ($groups as &$g) {
            $g['created_at'] = $now;
            $g['updated_at'] = $now;
        }

        $this->db->table('auth_groups')->insertBatch($groups);

        $this->forge->addForeignKey('group', 'auth_groups', 'name', 'CASCADE', 'CASCADE', 'fk_auth_groups_users_group');
        $this->forge->processIndexes('auth_groups_users');
    }

    public function down()
    {
        $this->forge->dropForeignKey('auth_groups_users', 'fk_auth_groups_users_group');
        $this->forge->dropTable('auth_groups');
    }
}
