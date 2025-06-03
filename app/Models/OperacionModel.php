<?php
namespace App\Models;

use CodeIgniter\Model;

class OperacionModel extends Model
{
    protected $table = 'operaciones';
    protected $primaryKey = 'id';

    public function listarPorDireccion($direccion_id = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('operaciones')->select('id, codigo, nombre');
        if ($direccion_id) $builder->where('direccion_id', $direccion_id);
        return $builder->orderBy('codigo')->get()->getResultArray();
    }
}