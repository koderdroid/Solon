<?php
namespace App\Models;

use CodeIgniter\Model;

class PoaFormulario1Model extends Model
{
    protected $table = 'formulario1';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'accion_corto_plazo', 'producto'
    ];
    public function getById($id)
    {
        return $this->find($id);
    }
    // Guarda la meta programada de 2025, sin borrar si ya existe y solo si hay cambio
    public function guardarMeta2025($form1_id, $valor)
    {
        $db = \Config\Database::connect();
        $row = $db->table('formulario1_vigente')->where('formulario1_id', $form1_id)->get()->getRowArray();
        if (!$row) {
            $db->table('formulario1_vigente')->insert([
                'formulario1_id' => $form1_id,
                'prog_2025' => $valor
            ]);
        } else if ($row['prog_2025'] != $valor) {
            $db->table('formulario1_vigente')->where('formulario1_id', $form1_id)
                ->update(['prog_2025' => $valor]);
        }
    }
    // Guarda el avance para el periodo 2025 indicado, sin sobrescribir el resto
    public function guardarAvance2025($form1_id, $periodo, $valor)
    {
        $db = \Config\Database::connect();
        // Tabla sugerida: formulario1_avance2025 (id, formulario1_id, periodo, valor)
        $row = $db->table('formulario1_avance2025')
            ->where('formulario1_id', $form1_id)->where('periodo', $periodo)->get()->getRowArray();
        if (!$row) {
            $db->table('formulario1_avance2025')->insert([
                'formulario1_id' => $form1_id,
                'periodo' => $periodo,
                'valor' => $valor
            ]);
        } else if ($row['valor'] != $valor) {
            $db->table('formulario1_avance2025')
                ->where('formulario1_id', $form1_id)->where('periodo', $periodo)
                ->update(['valor' => $valor]);
        }
    }
}