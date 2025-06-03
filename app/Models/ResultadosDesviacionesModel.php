<?php
namespace App\Models;
use CodeIgniter\Model;

class ResultadosDesviacionesModel extends Model
{
    protected $table = 'resultados_unidad';

    // ... otros métodos ...

    /**
     * Detecta desviaciones y retorna responsables de cada unidad/área con su email
     */
    public function getResponsablesConDesviaciones($periodo)
    {
        $db = \Config\Database::connect();
        // Datos de responsables (ajusta el JOIN a tu modelo real de usuarios)
        $query = $db->query("
            SELECT ru.*, u.nombre AS unidad_nombre, a.nombre AS area_nombre, us.email AS responsable_email, us.nombre AS responsable_nombre
            FROM resultados_unidad ru
            JOIN unidades u ON ru.unidad_id = u.id
            JOIN areas a ON ru.area_id = a.id
            JOIN usuarios us ON us.unidad_id = ru.unidad_id
            WHERE ru.periodo = ?
        ", [$periodo]);
        $rows = $query->getResultArray();

        // Carga indicadores y detecta desviaciones con alertas como antes
        $indicadores = $db->query("
            SELECT t.unidad_responsable_id AS unidad_id,
                   AVG(ta.avance) AS avance_fisico_real,
                   SUM(tp.presupuesto_ejecutado) AS presupuesto_ejecutado,
                   SUM(tp.presupuesto_vigente) AS presupuesto_vigente,
                   CASE WHEN SUM(tp.presupuesto_vigente)>0 THEN 100*SUM(tp.presupuesto_ejecutado)/SUM(tp.presupuesto_vigente) ELSE 0 END AS ejecucion_real,
                   AVG(ta.avance)/CASE WHEN SUM(tp.presupuesto_vigente)>0 THEN (100*SUM(tp.presupuesto_ejecutado)/SUM(tp.presupuesto_vigente)) ELSE 1 END AS eficiencia_real
            FROM tareas t
            LEFT JOIN tarea_avance ta ON ta.tarea_id = t.id AND ta.periodo = ?
            LEFT JOIN tarea_presupuesto tp ON tp.tarea_id = t.id AND tp.periodo = ?
            GROUP BY t.unidad_responsable_id
        ", [$periodo, $periodo])->getResultArray();
        $indMap = [];
        foreach($indicadores as $i) $indMap[$i['unidad_id']] = $i;

        $out = [];
        foreach($rows as $r) {
            $uid = $r['unidad_id'];
            $ind = $indMap[$uid] ?? null;
            $alertas = [];
            if ($ind) {
                if (isset($r['avance_fisico']) && abs($r['avance_fisico']-$ind['avance_fisico_real'])>3) {
                    $alertas[] = "Diferencia significativa en avance físico reportado vs. calculado";
                }
                if (isset($r['ejec_presupuestaria']) && abs($r['ejec_presupuestaria']-$ind['ejecucion_real'])>3) {
                    $alertas[] = "Diferencia significativa en ejecución presupuestaria";
                }
                if (isset($r['eficiencia']) && abs($r['eficiencia']-$ind['eficiencia_real'])>0.1) {
                    $alertas[] = "Eficiencia reportada no coincide con el dato consolidado";
                }
                if ($ind['avance_fisico_real']<60) {
                    $alertas[] = "Avance físico bajo (<60%)";
                }
                if ($ind['ejecucion_real']<70) {
                    $alertas[] = "Ejecución presupuestaria baja (<70%)";
                }
            }
            if (!empty($alertas)) {
                $r['alertas'] = $alertas;
                $out[] = $r;
            }
        }
        return $out;
    }
}