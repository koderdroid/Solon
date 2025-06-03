<?php
namespace App\Controllers;

class ReportesDinamicos extends BaseController
{
    public function index()
    {
        // Simulación: en real, cargar desde BD
        $ejecucion_tareas = [
            ['nombre'=>'1R','q_tarea'=>17,'ejec_poa'=>'97,65%','ejec_ppto'=>'95,22%'],
            ['nombre'=>'DRP - UC','q_tarea'=>7,'ejec_poa'=>'94,29%','ejec_ppto'=>'99,84%'],
            ['nombre'=>'1.1','q_tarea'=>2,'ejec_poa'=>'80,00%','ejec_ppto'=>'95,11%'],
            ['nombre'=>'SENAPE 1.1.1','q_tarea'=>1,'ejec_poa'=>'60,00%','ejec_ppto'=>'95,36%'],
            // ...completar todos los registros...
        ];
        return view('reportes_dinamicos_visualizacion', compact('ejecucion_tareas'));
    }
}