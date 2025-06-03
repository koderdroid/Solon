<?php

namespace App\Models;

use CodeIgniter\Model;

class PoaTareaModel extends Model
{
    protected $table      = 'poa_tareas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'descripcion', 'estado'];
}