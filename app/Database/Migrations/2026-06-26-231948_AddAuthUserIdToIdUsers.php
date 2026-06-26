<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAuthUserIdToIdUsers extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('id_users', [
            'auth_user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'attach_id'
            ]
        ]);
        $this->forge->addForeignKey('auth_user_id', 'users', 'id', 'CASCADE', 'CASCADE', 'fk_id_users_auth_user');
        $this->forge->processIndexes('id_users');
        $this->db->query('ALTER TABLE id_users ADD UNIQUE INDEX unique_auth_user (auth_user_id)');
    }

    public function down()
    {
        $this->forge->dropForeignKey('id_users', 'fk_id_users_auth_user');
        $this->forge->dropColumn('id_users', 'auth_user_id');
    }
}
