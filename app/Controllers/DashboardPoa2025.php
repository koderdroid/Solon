<?php
namespace App\Controllers;

class DashboardPoa2025 extends BaseController
{
    public function index()
    {
        // Datos simulados, carga reales desde BD/modelo
        $poa = [
            'acciones_estrategicas'=>3,
            'acciones_corto_plazo'=>8,
            'operaciones'=>69,
            'tareas'=>190,
            'presupuesto_vigente'=>21373333,
            'avance_fisico'=>99.23,
            'avance_financiero'=>96.32,
            'eficiencia_relativa'=>'0.99',
            'eficiencia_ponderada'=>'0.97'
        ];
        $avance_accion_estrategica = [
            [
                'nombre'=>'Sustantivas',
                'presupuesto_vigente'=>9314552.77,
                'presupuesto_ejecutado'=>9251725.60,
                'porc_presupuesto'=>'99.33',
                'porc_poa'=>'97.79',
                'eficiencia_ponderada'=>'0.99',
                'eficiencia_relativa'=>'98.77% Eficiente'
            ],
            [
                'nombre'=>'Apoyo',
                'presupuesto_vigente'=>10704988.18,
                'presupuesto_ejecutado'=>10401389.70,
                'porc_presupuesto'=>'97.16',
                'porc_poa'=>'99.11',
                'eficiencia_ponderada'=>'1.07',
                'eficiencia_relativa'=>'96.33% Eficiente'
            ],
            [
                'nombre'=>'Transparencia',
                'presupuesto_vigente'=>1353792.05,
                'presupuesto_ejecutado'=>1352737.22,
                'porc_presupuesto'=>'99.92',
                'porc_poa'=>'84.85',
                'eficiencia_ponderada'=>'0.90',
                'eficiencia_relativa'=>'95.08% Eficiente'
            ],
            [
                'nombre'=>'TOTAL',
                'presupuesto_vigente'=>21373333,
                'presupuesto_ejecutado'=>21005852.52,
                'porc_presupuesto'=>'98.28',
                'porc_poa'=>'97.16',
                'eficiencia_ponderada'=>'0.97',
                'eficiencia_relativa'=>'96.93% Eficiente'
            ]
        ];
        $indicadores = [
            'eficientes'=>22,
            'suficientes'=>3,
            'rezagados'=>2
        ];
        return view('dashboard_ejecutivo_poa2025', compact('poa','avance_accion_estrategica','indicadores'));
    }
}