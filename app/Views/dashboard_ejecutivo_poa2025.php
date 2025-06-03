<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard Ejecutivo POA 2025</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/css/bootstrap.min.css">
    <style>
        body { background:#f7fafd;}
        .main-title { font-size:1.5em; font-weight:bold; color:#1976d2;}
        .card-kpi { border-radius:10px; box-shadow:0 2px 8px #eaf1fa; }
        .kpi-label { color:#1976d2; font-size:1.07em;}
        .kpi-value { font-size:1.6em; font-weight:bold;}
        .kpi-minimo { font-size:0.92em; color:#999;}
        .table thead th { background:#e3eaf6; }
        .chart-container { background:#fff; border-radius:10px; box-shadow:0 2px 8px #eaf1fa; padding:1em; margin-bottom:1.2em;}
        .indicador-badge { margin-right: 0.5em; }
        .legend-dot { display:inline-block; width:14px; height:14px; border-radius:7px; margin-right:6px;}
        .dot-eficaz { background:#43a047;}
        .dot-suf { background:#fbc02d;}
        .dot-rez { background:#e53935;}
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container-xl mt-3 mb-3">
    <div class="main-title mb-2">Dashboard Ejecutivo — POA 2025</div>

    <!-- KPIs generales POA -->
    <div class="row g-2 mb-3">
        <div class="col-md-2">
            <div class="card card-kpi p-2">
                <div class="kpi-label">Acciones Estratégicas</div>
                <div class="kpi-value"><?= $poa['acciones_estrategicas'] ?></div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card card-kpi p-2">
                <div class="kpi-label">Acciones Corto Plazo</div>
                <div class="kpi-value"><?= $poa['acciones_corto_plazo'] ?></div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card card-kpi p-2">
                <div class="kpi-label">Operaciones</div>
                <div class="kpi-value"><?= $poa['operaciones'] ?></div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card card-kpi p-2">
                <div class="kpi-label">Tareas</div>
                <div class="kpi-value"><?= $poa['tareas'] ?></div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card card-kpi p-2">
                <div class="kpi-label">Presupuesto Vigente</div>
                <div class="kpi-value"><?= number_format($poa['presupuesto_vigente'],2,',','.') ?> Bs</div>
            </div>
        </div>
    </div>
    <div class="row g-2 mb-3">
        <div class="col-md-3">
            <div class="card card-kpi p-2">
                <div class="kpi-label">Avance Físico</div>
                <div class="kpi-value"><?= $poa['avance_fisico'] ?>%</div>
                <div class="kpi-minimo">Mínimo: 90%</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-kpi p-2">
                <div class="kpi-label">Avance Financiero</div>
                <div class="kpi-value"><?= $poa['avance_financiero'] ?>%</div>
                <div class="kpi-minimo">Mínimo: 90%</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-kpi p-2">
                <div class="kpi-label">Eficiencia Relativa</div>
                <div class="kpi-value"><?= $poa['eficiencia_relativa'] ?></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-kpi p-2">
                <div class="kpi-label">Eficiencia Ponderada</div>
                <div class="kpi-value"><?= $poa['eficiencia_ponderada'] ?></div>
            </div>
        </div>
    </div>

    <!-- Avance por Acción Estratégica (tabla y gráfico) -->
    <div class="chart-container mb-3">
        <div class="mb-2" style="font-weight:bold; color:#1976d2;">Avance por Acción Estratégica</div>
        <div class="table-responsive">
        <table class="table table-sm table-bordered align-middle mb-0">
            <thead>
                <tr>
                    <th>Área / Unidad</th>
                    <th>Presupuesto Vigente</th>
                    <th>Presupuesto Ejecutado</th>
                    <th>% Presupuesto Ejecutado</th>
                    <th>% POA Ejecutado</th>
                    <th>Eficiencia Ponderada</th>
                    <th>Eficiencia Relativa</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($avance_accion_estrategica as $fila): ?>
                <tr>
                    <td><?= esc($fila['nombre']) ?></td>
                    <td><?= number_format($fila['presupuesto_vigente'],2,',','.') ?></td>
                    <td><?= number_format($fila['presupuesto_ejecutado'],2,',','.') ?></td>
                    <td><?= $fila['porc_presupuesto'] ?>%</td>
                    <td><?= $fila['porc_poa'] ?>%</td>
                    <td><?= $fila['eficiencia_ponderada'] ?></td>
                    <td><?= $fila['eficiencia_relativa'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        <div class="row mt-3">
            <div class="col-md-8">
                <!-- Gráfico de barras horizontales -->
                <canvas id="bar_avance_estrategica" height="180"></canvas>
            </div>
            <div class="col-md-4">
                <div class="mb-2" style="font-weight:bold;">Cumplimiento de Indicadores</div>
                <span class="legend-dot dot-eficaz"></span> Eficientes: <?= $indicadores['eficientes'] ?><br>
                <span class="legend-dot dot-suf"></span> Suficientes: <?= $indicadores['suficientes'] ?><br>
                <span class="legend-dot dot-rez"></span> Rezagados: <?= $indicadores['rezagados'] ?><br>
            </div>
        </div>
    </div>

    <!-- Gráficos tipo imagen para simular barra 3D custom (como imágenes 5 y 6) -->
    <div class="chart-container">
        <div class="mb-2" style="font-weight:bold; color:#1976d2;">Representación visual (barras POA vs Presupuesto)</div>
        <div class="row">
            <div class="col-md-8">
                <!-- Puedes usar una imagen o recrear el gráfico con Chart.js -->
                <canvas id="bar_custom_poapresup" height="160"></canvas>
            </div>
            <div class="col-md-4">
                <img src="/path/to/imagen_5.png" class="img-fluid" alt="Barra POA-Presupuesto">
                <!-- O usa Chart.js para todo si lo prefieres -->
            </div>
        </div>
    </div>
</div>
<script>
// Datos para gráfico de avance por acción estratégica
const datosAE = <?= json_encode(array_map(function($f){
    return [
        'nombre'=>$f['nombre'],
        'poa'=>floatval($f['porc_poa']),
        'presupuesto'=>floatval($f['porc_presupuesto'])
    ];
}, $avance_accion_estrategica)) ?>;

const ctxAE = document.getElementById('bar_avance_estrategica').getContext('2d');
new Chart(ctxAE, {
    type: 'bar',
    data: {
        labels: datosAE.map(r=>r.nombre),
        datasets: [
            {
                label: '% POA',
                data: datosAE.map(r=>r.poa),
                backgroundColor: '#fbc02d'
            },
            {
                label: '% Presupuesto',
                data: datosAE.map(r=>r.presupuesto),
                backgroundColor: '#1976d2'
            }
        ]
    },
    options: {
        indexAxis: 'y',
        plugins: { legend: { position: 'top' } },
        scales: { x: { max: 100, beginAtZero: true, ticks:{ callback:v=>v+'%' } } }
    }
});

// Gráfico custom tipo imagen (barra 3D)
const ctxCustom = document.getElementById('bar_custom_poapresup').getContext('2d');
new Chart(ctxCustom, {
    type: 'bar',
    data: {
        labels: datosAE.map(r=>r.nombre),
        datasets: [
            {
                label: 'POA',
                data: datosAE.map(r=>r.poa),
                backgroundColor: '#ffccbc'
            },
            {
                label: 'Presupuesto',
                data: datosAE.map(r=>r.presupuesto),
                backgroundColor: '#90caf9'
            }
        ]
    },
    options: {
        indexAxis: 'y',
        plugins: { legend: { position: 'top' } },
        scales: { x: { max: 100, beginAtZero: true, ticks:{ callback:v=>v+'%' } } }
    }
});
</script>
</body>
</html>