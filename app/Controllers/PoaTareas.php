// ... (restante igual)
public function index()
{
    $model = new PoaTareaModel();

    // Filtros
    $estado     = $this->request->getGet('estado');
    $indicador  = $this->request->getGet('indicador_id');
    $periodo    = $this->request->getGet('periodo');

    $query = $model;
    if ($estado) {
        $query = $query->where('estado', $estado);
    }
    $data['tareas'] = $query->findAll();

    // Para el filtro por indicador y periodo, hay que buscar avances coincidentes
    $avanceModel = new \App\Models\AvanceTareaModel();
    $indicadorModel = new \App\Models\IndicadorModel();
    $data['indicadores'] = $indicadorModel->findAll();

    $tareas_ids = array_column($data['tareas'], 'id');
    $avances = [];
    if ($indicador || $periodo) {
        if ($tareas_ids) {
            $avanceQuery = $avanceModel->whereIn('tarea_id', $tareas_ids);
            if ($indicador) $avanceQuery->where('indicador_id', $indicador);
            if ($periodo)   $avanceQuery->where('periodo', $periodo);
            $avances = $avanceQuery->findAll();
        }
    }

    $data['avances_filtrados'] = $avances;
    $data['filtros'] = [
        'estado' => $estado, 'indicador_id' => $indicador, 'periodo' => $periodo
    ];
    return view('poa_tareas/index', $data);
}