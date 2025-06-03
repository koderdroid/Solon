<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePoaTareas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nombre'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'descripcion' => ['type' => 'TEXT', 'null' => true],
            'estado'      => ['type' => 'VARCHAR', 'constraint' => 40, 'default' => 'En Proceso'],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('poa_tareas');
    }

    public function down()
    {
        $this->forge->dropTable('poa_tareas');
    }
}