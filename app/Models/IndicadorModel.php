<?php

namespace App\Models;

use CodeIgniter\Model;

class IndicadorModel extends Model
{
    protected $table = 'indicadores';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'codigo', 'nombre', 'formula', 'meta', 'area', 'descripcion', 'tipo'
    ];
}