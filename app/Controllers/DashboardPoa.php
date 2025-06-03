// Controlador: para Sankey, Maps y Chart.js (ejemplo)
public function mapsankey()
{
    $periodo = $this->request->getGet('periodo') ?? '2025-01';
    $model = new \App\Models\DashboardModel();
    $kpis = [
        'avance_fisico_global'      => $model->avance_fisico_global($periodo),
        'ejecucion_presupuestaria_global' => $model->ejecucion_presupuestaria_global($periodo),
        'eficiencia_global'         => $model->eficiencia_global($periodo),
        'riesgo'                    => $model->riesgo_global($periodo)
    ];
    $detalle = [
        'areas' => $model->detalle_areas($periodo),
        'unidades' => $model->detalle_unidades($periodo),
        'operaciones' => $model->detalle_operaciones($periodo)
    ];
    $historico = $model->historico_avance(['2025-01','2025-02','2025-03','2025-04']);
    return view('dashboard/impact_dashboard_mapsankey', [
        'kpis' => $kpis,
        'detalle' => $detalle,
        'historico' => $historico
    ]);
}