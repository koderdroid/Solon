<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAvanceTarea extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'tarea_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'indicador_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'periodo'      => ['type' => 'VARCHAR', 'constraint' => 24],
            'avance_texto' => ['type' => 'TEXT'],
            'usuario'      => ['type' => 'VARCHAR', 'constraint' => 100],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('tarea_id', 'poa_tareas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('indicador_id', 'indicadores', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('avance_tarea');
    }

    public function down()
    {
        $this->forge->dropTable('avance_tarea');
    }
}