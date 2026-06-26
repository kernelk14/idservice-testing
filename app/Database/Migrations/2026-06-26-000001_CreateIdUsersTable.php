<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIdUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'userId'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'            => ['type' => 'VARCHAR', 'constraint' => 255],
            'email'           => ['type' => 'VARCHAR', 'constraint' => 255],
            'contact_num'     => ['type' => 'VARCHAR', 'constraint' => 50],
            'address'         => ['type' => 'TEXT'],
            'emergency_person'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'emergency_number'   => ['type' => 'VARCHAR', 'constraint' => 50],
            'attach_id'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ]);
        $this->forge->addKey('userId', true);
        $this->forge->createTable('id_users', true);
    }

    public function down()
    {
        $this->forge->dropTable('id_users');
    }
}
