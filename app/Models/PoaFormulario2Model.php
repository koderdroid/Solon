<?php
namespace App\Models;

use CodeIgniter\Model;

class PoaFormulario2Model extends Model
{
    // No tabla por defecto: queries jerárquicos
    public function obtener_formulario2($direccion_id)
    {
        $db = \Config\Database::connect();
        $sql = "SELECT
                    o.codigo AS codigo_operacion,
                    o.nombre AS nombre_operacion,
                    t.id AS codigo_tarea,
                    t.descripcion AS descripcion_tarea,
                    t.medios_verificacion,
                    t.responsable,
                    t.periodo,
                    t.pond_tarea,
                    t.estado_cumplimiento,
                    t.avance_porcentaje,
                    t.observaciones,
                    t.documento_adjunto,
                    t.usuario_registro,
                    t.fecha_registro
                FROM operaciones o
                JOIN tareas t ON t.operacion_id = o.id
                WHERE o.direccion_id = ?
                ORDER BY o.codigo, t.id";
        $query = $db->query($sql, [$direccion_id]);
        return $query->getResultArray();
    }
}