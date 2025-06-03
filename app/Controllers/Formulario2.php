<?php
namespace App\Controllers;

use App\Models\Formulario2Model;
use CodeIgniter\Controller;

class Formulario2 extends Controller
{
    // Vista de avance y presupuesto (carga/edición)
    public function editar($area_id, $periodo)
    {
        $model = new Formulario2Model();
        $db = \Config\Database::connect();
        // Datos principales
        $area = $db->table('areas')->where('id', $area_id)->get()->getRowArray();
        $operaciones = $db->table('operaciones')->where('area_id', $area_id)->get()->getResultArray();
        $tareas = [];
        foreach ($operaciones as $op) {
            $tareas[$op['id']] = $db->table('tareas')->where('operacion_id', $op['id'])->get()->getResultArray();
        }
        // Avances y presupuestos actuales
        $avances = [];
        $presupuestos = [];
        foreach ($operaciones as $op) {
            foreach ($tareas[$op['id']] as $t) {
                $avance = $db->table('tarea_avance')->where('tarea_id', $t['id'])->where('periodo', $periodo)->get()->getRowArray();
                $avances[$t['id']] = $avance ? $avance['avance'] : '';
                $pres = $db->table('tarea_presupuesto')->where('tarea_id', $t['id'])->where('periodo', $periodo)->get()->getRowArray();
                $presupuestos[$t['id']] = $pres ? $pres : ['presupuesto_vigente'=>0,'presupuesto_ejecutado'=>0];
            }
        }
        // Presupuesto de área
        $area_pres = $db->table('area_presupuesto')->where('area_id', $area_id)->where('periodo', $periodo)->get()->getRowArray();
        return view('poa/formulario2_editar', [
            'area' => $area,
            'operaciones' => $operaciones,
            'tareas' => $tareas,
            'avances' => $avances,
            'presupuestos' => $presupuestos,
            'area_pres' => $area_pres,
            'periodo' => $periodo
        ]);
    }

    // Guardar avances y presupuesto ejecutado
    public function guardar()
    {
        $model = new Formulario2Model();
        $area_id = $this->request->getPost('area_id');
        $periodo = $this->request->getPost('periodo');
        $pres_ejec = $this->request->getPost('presupuesto_ejecutado'); // Presupuesto ejecutado por área

        // 1. Guardar presupuesto ejecutado de área
        $db = \Config\Database::connect();
        $db->table('area_presupuesto')->where('area_id', $area_id)->where('periodo', $periodo)
            ->update(['presupuesto_ejecutado' => floatval($pres_ejec)]);

        // 2. Guardar avances de tareas
        $avances = $this->request->getPost('avance');
        foreach ($avances as $tarea_id => $valor) {
            $row = $db->table('tarea_avance')->where('tarea_id', $tarea_id)->where('periodo', $periodo)->get()->getRowArray();
            if ($row)
                $db->table('tarea_avance')->where('id', $row['id'])->update(['avance'=>floatval($valor)]);
            else
                $db->table('tarea_avance')->insert(['tarea_id'=>$tarea_id, 'periodo'=>$periodo, 'avance'=>floatval($valor)]);
        }

        // 3. Distribuir presupuesto por ponderación a tareas
        $model->distribuir_presupuesto($area_id, $periodo);

        // Redirigir a la vista de edición
        return redirect()->to("/formulario2/editar/$area_id/$periodo?guardado=1");
    }
}