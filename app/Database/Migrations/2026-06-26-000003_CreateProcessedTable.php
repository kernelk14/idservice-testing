<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProcessedTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'userId'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'processed_by'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'processed_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('userId');
        $this->forge->createTable('processed', true);
    }

    public function down()
    {
        $this->forge->dropTable('processed');
    }
}
