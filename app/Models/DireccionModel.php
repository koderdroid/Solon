<?php
namespace App\Models;

use CodeIgniter\Model;

class DireccionModel extends Model
{
    protected $table = 'direcciones';
    protected $primaryKey = 'id';

    /**
     * Devuelve resumen para dashboard (por dirección, para cards y gráficos)
     */
    public function dashboardResumen($direccion_id = null)
    {
        $db = \Config\Database::connect();
        // Por dirección
        $sql = "SELECT d.id, d.nombre,
            COUNT(t.id) AS total_tareas,
            COALESCE(SUM(CASE WHEN t.estado_cumplimiento THEN 1 ELSE 0 END),0) AS tareas_cumplidas,
            COALESCE(SUM(CASE WHEN t.estado_cumplimiento THEN 0 ELSE 1 END),0) AS tareas_pendientes,
            ROUND(COALESCE(SUM(CASE WHEN t.estado_cumplimiento THEN 1 ELSE 0 END),0)::decimal / NULLIF(COUNT(t.id),0) * 100, 2) AS porcentaje_cumplimiento,
            ROUND(AVG(t.avance_porcentaje),2) AS avance_promedio
            FROM direcciones d
            LEFT JOIN operaciones o ON o.direccion_id = d.id
            LEFT JOIN tareas t ON t.operacion_id = o.id";
        if ($direccion_id) {
            $sql .= " WHERE d.id = ?";
            $dirs = $db->query($sql." GROUP BY d.id, d.nombre ORDER BY d.id", [$direccion_id])->getResultArray();
        } else {
            $dirs = $db->query($sql." GROUP BY d.id, d.nombre ORDER BY d.id")->getResultArray();
        }
        // Cards globales
        $total_tareas = 0; $t_cumplidas = 0; $t_pendientes = 0; $cumpl = 0; $avance = 0; $n = 0;
        foreach($dirs as $d) {
            $total_tareas += $d['total_tareas'];
            $t_cumplidas += $d['tareas_cumplidas'];
            $t_pendientes += $d['tareas_pendientes'];
            $cumpl += $d['porcentaje_cumplimiento'];
            $avance += $d['avance_promedio'];
            $n++;
        }
        return [
            'direcciones' => $dirs,
            'total_tareas' => $total_tareas,
            'tareas_cumplidas' => $t_cumplidas,
            'tareas_pendientes' => $t_pendientes,
            'porcentaje_cumplimiento' => $n ? round($cumpl/$n,2) : 0,
            'avance_promedio' => $n ? round($avance/$n,2) : 0,
        ];
    }
}