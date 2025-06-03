<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reportes Dinámicos - Visualización</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/css/bootstrap.min.css">
    <style>
        body { background: #f7fafd; }
        .main-title { font-size:1.3em; font-weight:bold; color:#1976d2;}
        .chart-container { background: #fff; border-radius:10px; margin-bottom:1.3em; box-shadow:0 2px 8px #eaf1fa; padding:1em;}
        .table th, .table td { font-size:0.98em; }
        .pdf-btn { float:right; margin-left:1em; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</head>
<body>
<div class="container-xl mt-3 mb-3" id="reporte-dinamico-main">
    <div class="main-title mb-2">
        Reportes Dinámicos — Visualización y Exportación
        <button class="btn btn-danger pdf-btn" onclick="exportToPDF()">Exportar PDF</button>
        <button class="btn btn-primary pdf-btn" onclick="window.print()">Imprimir</button>
    </div>

    <!-- Gráfico: Distribución de Tareas por Área -->
    <div class="chart-container mb-3">
        <div style="font-weight:bold; color:#1976d2;">Distribución de cantidad de Tareas por Área</div>
        <canvas id="bar_tareas_area" height="110"></canvas>
    </div>

    <!-- Gráfico: Distribución de Operaciones por Área -->
    <div class="chart-container mb-3">
        <div style="font-weight:bold; color:#1976d2;">Distribución de cantidad de Operaciones por Área</div>
        <canvas id="bar_operaciones_area" height="110"></canvas>
    </div>

    <!-- Gráfico: Ponderación de Operaciones por Área (Stacked) -->
    <div class="chart-container mb-3">
        <div style="font-weight:bold; color:#1976d2;">Distribución de ponderación de Operaciones por Área</div>
        <canvas id="stack_ponderacion_operaciones" height="210"></canvas>
    </div>

    <!-- Tabla: Ejecución POA y Presupuesto a nivel de Tarea -->
    <div class="chart-container mb-3">
        <div style="font-weight:bold; color:#1976d2;">Reporte de cantidades, Ejecución POA y Presupuesto a nivel de Tarea</div>
        <div class="table-responsive">
        <table class="table table-bordered table-sm align-middle">
            <thead>
                <tr>
                    <th>Unidad y Área</th>
                    <th>Cant. Tareas</th>
                    <th>Ejec. POA (%)</th>
                    <th>Ejec. Ppto (%)</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($ejecucion_tareas as $fila): ?>
                <tr>
                    <td><?= esc($fila['nombre']) ?></td>
                    <td><?= esc($fila['q_tarea']) ?></td>
                    <td><?= esc($fila['ejec_poa']) ?></td>
                    <td><?= esc($fila['ejec_ppto']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>
</div>
<script>
// Datos de ejemplo. Rellenar dinámicamente desde PHP/backend.
const tareasPorArea = {
    labels: ["1R", "2D", "3L", "4A", "5J", "6O", "7I", "8T"],
    data: [20, 12, 19, 61, 11, 49, 17, 5]
};
const operacionesPorArea = {
    labels: ["1R", "2D", "3L", "4A", "5J", "6O", "7I", "8T"],
    data: [7, 7, 9, 18, 7, 15, 10, 1]
};
// Ponderación de operaciones por área (stacked bar chart)
const ponderacionOperaciones = {
    labels: [
        "1R","2D","3L","4A","5J","6O","7I","8T"
    ],
    datasets: [
        // Para gráfico stacked, cada segmento es una operación
        // Solo ejemplo, en real separar cada suboperación
        // ["1.1","1.2",...], ["2.1",...], etc. y sus %.
        {label:"1.1", data:[20,0,0,0,0,0,0,0], backgroundColor:'#1976d2'},
        {label:"1.2", data:[20,0,0,0,0,0,0,0], backgroundColor:'#2196f3'},
        {label:"1.3", data:[8,0,0,0,0,0,0,0], backgroundColor:'#64b5f6'},
        // ...agregar todas las suboperaciones de cada área...
        {label:"2.1", data:[0,10,0,0,0,0,0,0], backgroundColor:'#43a047'},
        // ...
        {label:"8.1", data:[0,0,0,0,0,0,0,100], backgroundColor:'#fbc02d'}
    ]
};
// Ejecución POA y Presupuesto por tarea (tabla)
const ejecucionTareas = <?= json_encode($ejecucion_tareas) ?>;

// Chart.js: Tareas por Área
new Chart(document.getElementById('bar_tareas_area').getContext('2d'), {
    type: 'bar',
    data: {
        labels: tareasPorArea.labels,
        datasets: [{
            label: 'Cantidad de Tareas',
            data: tareasPorArea.data,
            backgroundColor: '#1976d2',
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks:{stepSize:10} } }
    }
});

// Chart.js: Operaciones por Área
new Chart(document.getElementById('bar_operaciones_area').getContext('2d'), {
    type: 'bar',
    data: {
        labels: operacionesPorArea.labels,
        datasets: [{
            label: 'Cantidad de Operaciones',
            data: operacionesPorArea.data,
            backgroundColor: '#43a047',
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks:{stepSize:5} } }
    }
});

// Chart.js: Ponderación de Operaciones por Área (stacked)
new Chart(document.getElementById('stack_ponderacion_operaciones').getContext('2d'), {
    type: 'bar',
    data: {
        labels: ponderacionOperaciones.labels,
        datasets: ponderacionOperaciones.datasets
    },
    options: {
        plugins: { legend: { position: 'right' } },
        responsive: true,
        scales: {
            x: { stacked: true },
            y: { stacked: true, max: 100, beginAtZero: true, ticks:{callback:v=>v+'%'} }
        }
    }
});

// Exportar a PDF con html2pdf
function exportToPDF() {
    const element = document.getElementById('reporte-dinamico-main');
    html2pdf().set({
        margin:       0.5,
        filename:     'reporte-dinamico.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2, useCORS: true },
        jsPDF:        { unit: 'in', format: 'a4', orientation: 'landscape' }
    }).from(element).save();
}
</script>
</body>
</html>