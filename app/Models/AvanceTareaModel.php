<?php

namespace App\Models;

use CodeIgniter\Model;

class AvanceTareaModel extends Model
{
    protected $table      = 'avance_tarea';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'tarea_id', 'indicador_id', 'periodo', 'avance_texto', 'usuario'
    ];

    public function getAvancesPorTarea($tarea_id)
    {
        return $this->where('tarea_id', $tarea_id)->orderBy('created_at', 'desc')->findAll();
    }
}