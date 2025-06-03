<?php
namespace App\Models;

use CodeIgniter\Model;

class UnidadModel extends Model
{
    protected $table = 'unidades';
    protected $primaryKey = 'id';

    public function listarPorArea($area_id = null)
    {
        $builder = $this->db->table($this->table)->select('id, nombre');
        if ($area_id) $builder->where('area_id', $area_id);
        return $builder->orderBy('id')->get()->getResultArray();
    }
}