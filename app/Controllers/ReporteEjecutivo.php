<?php
namespace App\Controllers;

use App\Models\IndicadoresModel;

class ReporteEjecutivo extends BaseController
{
    public function index()
    {
        $model = new IndicadoresModel();
        // KPIs y tendencias
        $kpis = $model->getKPIs();
        // Series de indicadores (puedes agregar más)
        $indicadores = [
            'recursos' => $model->getIndicadorRecursosTGN(),
            'sicepa'   => $model->getIndicadorSICEPA(),
            'cibid'    => $model->getIndicadorCIBID(),
        ];
        return view('reporte_ejecutivo', compact('kpis','indicadores'));
    }
}