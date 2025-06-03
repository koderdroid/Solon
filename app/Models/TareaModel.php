<?php
namespace App\Models;

use CodeIgniter\Model;

class TareaModel extends Model
{
    protected $table = 'tareas';
    protected $primaryKey = 'id';

    // Ahora acepta filtro por unidad responsable
    public function dashboardTareas($area_id = null, $operacion_id = null, $tarea_id = null, $cumplimiento = null, $unidad_id = null)
    {
        $builder = $this->db->table('tareas t')
            ->select('t.*, o.codigo AS operacion_codigo, o.nombre AS operacion_nombre, d.nombre AS direccion_nombre')
            ->join('operaciones o', 't.operacion_id = o.id')
            ->join('areas d', 'o.area_id = d.id');

        if ($area_id) { $builder->where('d.id', $area_id); }
        if ($operacion_id) { $builder->where('o.id', $operacion_id); }
        if ($tarea_id) { $builder->where('t.id', $tarea_id); }
        if (isset($cumplimiento) && $cumplimiento !== '') {
            $builder->where('t.estado_cumplimiento', $cumplimiento);
        }
        if ($unidad_id) {
            $builder->where('t.unidad_responsable_id', $unidad_id);
        }
        return $builder->orderBy('o.codigo')->orderBy('t.id')->get()->getResultArray();
    }

    public function guardarAvancePeriodo($tarea_id, $periodo, $avance, $cumplido, $obs, $usuario)
    {
        $db = \Config\Database::connect();
        $row = $db->table('tarea_avance')->where('tarea_id', $tarea_id)->where('periodo', $periodo)->get()->getRowArray();
        $data = [
            'avance' => $avance,
            'estado_cumplimiento' => $cumplido,
            'observaciones' => $obs,
            'usuario_registro' => $usuario,
            'fecha_registro' => date('Y-m-d H:i:s')
        ];
        if (!$row) {
            $data['tarea_id'] = $tarea_id;
            $data['periodo'] = $periodo;
            $db->table('tarea_avance')->insert($data);
        } else {
            $db->table('tarea_avance')->where('tarea_id', $tarea_id)->where('periodo', $periodo)->update($data);
        }
        // Actualiza avance y estado principal (tabla tareas)
        $db->table('tareas')->where('id', $tarea_id)->update([
            'avance_porcentaje' => $avance,
            'estado_cumplimiento' => $cumplido,
            'observaciones' => $obs,
        ]);
    }
}