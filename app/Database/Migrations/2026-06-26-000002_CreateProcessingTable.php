<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProcessingTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'userId'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'processed_by'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('userId');
        $this->forge->createTable('processing', true);
    }

    public function down()
    {
        $this->forge->dropTable('processing');
    }
}
