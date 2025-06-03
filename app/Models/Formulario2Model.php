<?php
namespace App\Models;

use CodeIgniter\Model;

class Formulario2Model extends Model
{
    // Distribuye el presupuesto del área por ponderación a tareas/operaciones
    public function distribuir_presupuesto($area_id, $periodo)
    {
        $db = \Config\Database::connect();
        // 1. Obtener presupuesto área
        $pres = $db->table('area_presupuesto')
            ->where('area_id', $area_id)
            ->where('periodo', $periodo)
            ->get()->getRowArray();

        if (!$pres) return false;

        $pres_vig = floatval($pres['presupuesto_vigente']);
        $pres_ejec = floatval($pres['presupuesto_ejecutado']);

        // 2. Todas las operaciones y tareas de esa área
        $ops = $db->table('operaciones')->select('id')->where('area_id', $area_id)->get()->getResultArray();
        foreach ($ops as $op) {
            $tareas = $db->table('tareas')->select('id,ponderacion')->where('operacion_id', $op['id'])->get()->getResultArray();
            foreach($tareas as $t) {
                $porc = floatval($t['ponderacion'])/100.0;
                $dist_vig = $pres_vig * $porc;
                $dist_ejec = $pres_ejec * $porc;
                // Insert/update en tabla tarea_presupuesto
                $row = $db->table('tarea_presupuesto')
                    ->where('tarea_id', $t['id'])->where('periodo', $periodo)->get()->getRowArray();
                $data = [
                    'tarea_id' => $t['id'],
                    'periodo' => $periodo,
                    'presupuesto_vigente' => $dist_vig,
                    'presupuesto_ejecutado' => $dist_ejec
                ];
                if ($row)
                    $db->table('tarea_presupuesto')->where('id', $row['id'])->update($data);
                else
                    $db->table('tarea_presupuesto')->insert($data);
            }
        }
        return true;
    }

    // Avance físico consolidado por operación
    public function avance_operacion($operacion_id, $periodo)
    {
        $db = \Config\Database::connect();
        // Promedio simple del avance de las tareas de la operación
        $builder = $db->table('tarea_avance ta')
            ->select('AVG(ta.avance) as avance_promedio')
            ->join('tareas t', 'ta.tarea_id = t.id')
            ->where('t.operacion_id', $operacion_id)
            ->where('ta.periodo', $periodo);
        $row = $builder->get()->getRowArray();
        return floatval($row['avance_promedio'] ?? 0);
    }

    // Avance físico consolidado por área
    public function avance_area($area_id, $periodo)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tarea_avance ta')
            ->select('AVG(ta.avance) as avance_promedio')
            ->join('tareas t', 'ta.tarea_id = t.id')
            ->join('operaciones o', 't.operacion_id = o.id')
            ->where('o.area_id', $area_id)
            ->where('ta.periodo', $periodo);
        $row = $builder->get()->getRowArray();
        return floatval($row['avance_promedio'] ?? 0);
    }

    // % ejecución presupuestaria área u operación
    public function ejecucion_presupuesto_area($area_id, $periodo)
    {
        $db = \Config\Database::connect();
        $row = $db->table('area_presupuesto')->where('area_id', $area_id)->where('periodo', $periodo)->get()->getRowArray();
        if (!$row || floatval($row['presupuesto_vigente'])==0) return 0;
        return round(100*floatval($row['presupuesto_ejecutado'])/floatval($row['presupuesto_vigente']),2);
    }
    public function ejecucion_presupuesto_operacion($operacion_id, $periodo)
    {
        $db = \Config\Database::connect();
        // Suma presupuestos de tareas de la operación en el periodo
        $suma = $db->table('tarea_presupuesto')
            ->select('SUM(presupuesto_ejecutado) as ejecutado, SUM(presupuesto_vigente) as vigente')
            ->join('tareas', 'tarea_presupuesto.tarea_id = tareas.id')
            ->where('tareas.operacion_id', $operacion_id)
            ->where('tarea_presupuesto.periodo', $periodo)
            ->get()->getRowArray();
        if (!$suma || floatval($suma['vigente'])==0) return 0;
        return round(100*floatval($suma['ejecutado'])/floatval($suma['vigente']),2);
    }
}