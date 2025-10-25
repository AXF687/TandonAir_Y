<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Mode extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'auto_increment' => true,
                'unsigned'       => false,
            ],
            'mode' => [
                'type'       => 'VARCHAR',
                'constraint' => '10', // Auto atau Manual
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('mode');
    }

    public function down()
    {
        $this->forge->dropTable('mode');
    }
}