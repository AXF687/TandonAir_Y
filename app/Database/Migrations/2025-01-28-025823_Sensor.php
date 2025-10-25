<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Sensor extends Migration
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
            'suhu' => [
                'type'       => 'VARCHAR',
                'constraint' => '6',
            ],
            'kelembaban' => [
                'type'       => 'VARCHAR',
                'constraint' => '3',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('sensor');
        }
        
        public function down()
        {
        $this->forge->dropTable('kendalirelay');
        }
}
