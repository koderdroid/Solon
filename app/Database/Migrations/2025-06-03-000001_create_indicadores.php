<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIndicadores extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'codigo'     => ['type' => 'VARCHAR', 'constraint' => 50],
            'nombre'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'formula'    => ['type' => 'TEXT', 'null' => true],
            'meta'       => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'area'       => ['type' => 'VARCHAR', 'constraint' => 80, 'null' => true],
            'tipo'       => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'descripcion'=> ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('indicadores');
    }

    public function down()
    {
        $this->forge->dropTable('indicadores');
    }
}