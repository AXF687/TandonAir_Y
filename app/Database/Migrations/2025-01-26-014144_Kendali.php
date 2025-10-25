<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kendali extends Migration
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
            'relay' => [
                'type'       => 'VARCHAR',
                'constraint' => '1',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('kendalirelay');
        }
        
        public function down()
        {
        $this->forge->dropTable('kendalirelay');
        }
}
