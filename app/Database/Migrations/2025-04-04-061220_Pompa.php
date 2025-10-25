<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pompa extends Migration
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
            'pompa' => [
                'type'       => 'VARCHAR',
                'constraint' => '6',
            ],
            'manual' => [
                'type'       => 'VARCHAR',
                'constraint' => '1',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pompa');
        }
        
        public function down()
        {
        $this->forge->dropTable('pompa');
        }
}
