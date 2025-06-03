<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard Impactante POA</title>
    <!-- Google Charts Loader -->
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- html2canvas for export to image -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <!-- jsPDF for export to PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f4f8fb;}
        .dashboard-container { background: #fff; border-radius:12px; box-shadow:0 4px 16px #b3c6d1; margin:2em auto; padding:2em; max-width:1400px;}
        .kpi-cards { display:flex; gap:1.2em; margin-bottom:2em;}
        .kpi-card { flex:1; background:linear-gradient(120deg,#e8f5e9,#e3f2fd); border-radius:9px; padding:1.2em; text-align:center; transition:box-shadow .2s;}
        .kpi-card:hover { box-shadow:0 2px 16px #cfd8dc;}
        .kpi-value { font-size:2.1em; font-weight:bold; color:#1976d2;}
        .kpi-label { font-size:1.09em; margin-top:.5em;}
        .charts-row { display:flex; gap:2em; margin-bottom:2em;}
        .charts-row>div { flex:1;}
        .bar-panels { display:flex; gap:2em; }
        .bar-panels>div { flex:1;}
        .drilldown-panel { margin-top:2.2em;}
        .level-btns button { margin:0 5px 10px 0; border:none; background:#e3f2fd; color:#1976d2; padding:7px 16px; border-radius:7px; font-weight:bold; cursor:pointer;}
        .level-btns .active { background:#1976d2; color:#fff;}
        .export-btns { float:right; margin-top:-20px;}
        .export-btns button { margin-left:8px; border:none; background:#1976d2; color:#fff; padding:7px 16px; border-radius:7px; font-weight:bold; cursor:pointer;}
        .export-btns button:hover { background:#43a047;}
        .dashboard-title { font-size:2em; font-weight:bold; color:#1976d2; margin-bottom:.4em;}
    </style>
</head>
<body>
<div class="dashboard-container" id="dashboard-main">
    <div class="dashboard-title">Dashboard Integral de Eficiencia Operativa y Financiera POA</div>
    <div class="export-btns">
        <button onclick="exportImage()">Exportar Imagen</button>
        <button onclick="exportPDF()">Exportar PDF</button>
    </div>
    <!-- KPIs principales -->
    <div class="kpi-cards">
        <div class="kpi-card">
            <div class="kpi-value"><?= round($kpis['avance_fisico_global'],2) ?>%</div>
            <div class="kpi-label">Avance Físico Global</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-value"><?= round($kpis['ejecucion_presupuestaria_global'],2) ?>%</div>
            <div class="kpi-label">% Ejecución Presupuestaria</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-value"><?= round($kpis['eficiencia_global'],2) ?></div>
            <div class="kpi-label">Índice de Eficiencia</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-value"><?= round($kpis['riesgo'],2) ?>%</div>
            <div class="kpi-label">Riesgo de Incumplimiento</div>
        </div>
    </div>
    <!-- Velocímetros -->
    <div class="charts-row">
        <div id="gauge_avance_fisico" style="height:260px;"></div>
        <div id="gauge_eficiencia" style="height:260px;"></div>
    </div>
    <!-- Barras de áreas y drilldown -->
    <div class="bar-panels">
        <div>
            <div style="font-weight:bold; margin-bottom:.5em;">Avance Físico por Área</div>
            <div id="bar_avance_area" style="height:340px;"></div>
        </div>
        <div>
            <div style="font-weight:bold; margin-bottom:.5em;">% Ejecución Presupuestaria por Área</div>
            <div id="bar_pres_area" style="height:340px;"></div>
        </div>
    </div>
    <!-- Drilldown interactivo -->
    <div class="drilldown-panel">
        <div class="level-btns">
            <button class="active" onclick="setLevel('area')">Nivel Área</button>
            <button onclick="setLevel('unidad')">Nivel Unidad</button>
            <button onclick="setLevel('operacion')">Nivel Operación</button>
        </div>
        <div id="drilldown_chart" style="height:400px;"></div>
    </div>
</div>

<script>
google.charts.load('current', {packages:['gauge','corechart','bar']});
google.charts.setOnLoadCallback(drawAllCharts);

let nivelActual = 'area';

function drawAllCharts() {
    // KPIs
    const avanceFisico = <?= floatval($kpis['avance_fisico_global']) ?>;
    const eficiencia = <?= floatval($kpis['eficiencia_global']) ?>;

    // Velocímetro Avance Físico
    var gaugeData = google.visualization.arrayToDataTable([
        ['Label', 'Value'],
        ['Avance', avanceFisico]
    ]);
    var gaugeOptions = {
        min: 0, max: 100,
        greenFrom: 80, greenTo: 100,
        yellowFrom: 60, yellowTo: 80,
        redFrom: 0, redTo: 60,
        minorTicks: 5,
        majorTicks: ['0%','20%','40%','60%','80%','100%'],
        animation:{duration:600,easing:'out'},
        width: '100%', height: 250
    };
    var gaugeChart = new google.visualization.Gauge(document.getElementById('gauge_avance_fisico'));
    gaugeChart.draw(gaugeData, gaugeOptions);

    // Velocímetro Eficiencia (puede adaptarse para distintos rangos)
    var gaugeData2 = google.visualization.arrayToDataTable([
        ['Label', 'Value'],
        ['Eficiencia', eficiencia]
    ]);
    var gaugeOptions2 = {
        min: 0, max: 2,
        greenFrom: 1.5, greenTo: 2,
        yellowFrom: 1, yellowTo: 1.5,
        redFrom: 0, redTo: 1,
        minorTicks: 5,
        majorTicks: ['0','0.5','1','1.5','2'],
        animation:{duration:600,easing:'out'},
        width: '100%', height: 250
    };
    var gaugeChart2 = new google.visualization.Gauge(document.getElementById('gauge_eficiencia'));
    gaugeChart2.draw(gaugeData2, gaugeOptions2);

    // Barras avance por área
    var dataAvanceArea = google.visualization.arrayToDataTable([
        ['Área', 'Avance Físico (%)'],
        <?php foreach($detalle['areas'] as $a): ?>
        ['<?= esc($a['nombre']) ?>', <?= floatval($a['avance_fisico']) ?>],
        <?php endforeach; ?>
    ]);
    var optionsAvanceArea = {
        legend:{position:'none'},
        hAxis: { minValue: 0, maxValue: 100, format: '#\'%\'' },
        chartArea: {width:'80%',height:'75%'}
    };
    var chartAvanceArea = new google.visualization.BarChart(document.getElementById('bar_avance_area'));
    chartAvanceArea.draw(dataAvanceArea, optionsAvanceArea);

    // Barras ejecución presupuestaria por área
    var dataPresArea = google.visualization.arrayToDataTable([
        ['Área', '% Ejecución'],
        <?php foreach($detalle['areas'] as $a): ?>
        ['<?= esc($a['nombre']) ?>', <?= floatval($a['presupuesto_ejec']) ?>],
        <?php endforeach; ?>
    ]);
    var optionsPresArea = {
        legend:{position:'none'},
        hAxis: { minValue: 0, maxValue: 100, format: '#\'%\'' },
        chartArea: {width:'80%',height:'75%'}
    };
    var chartPresArea = new google.visualization.BarChart(document.getElementById('bar_pres_area'));
    chartPresArea.draw(dataPresArea, optionsPresArea);

    drawDrilldownChart(nivelActual);
}

// Drilldown por nivel (área, unidad, operación)
function setLevel(nivel) {
    nivelActual = nivel;
    document.querySelectorAll('.level-btns button').forEach(btn => btn.classList.remove('active'));
    let idx = {area:0,unidad:1,operacion:2}[nivel];
    document.querySelectorAll('.level-btns button')[idx].classList.add('active');
    drawDrilldownChart(nivel);
}
function drawDrilldownChart(nivel) {
    let chartData, options, titulo;
    <?php // Prepara los datos PHP para JS ?>
    const dataUnidad = [
        ['Unidad','Avance Físico','% Ejecución'],
        <?php foreach($detalle['unidades'] as $u): ?>
        ['<?= esc($u['nombre']) ?>', <?= floatval($u['avance_fisico']) ?>, <?= floatval($u['presupuesto_ejec']) ?>],
        <?php endforeach; ?>
    ];
    const dataOperacion = [
        ['Operación','Avance Físico','% Ejecución'],
        <?php foreach($detalle['operaciones'] as $o): ?>
        ['<?= esc($o['nombre']) ?>', <?= floatval($o['avance_fisico']) ?>, <?= floatval($o['presupuesto_ejec']) ?>],
        <?php endforeach; ?>
    ];
    if(nivel==='area'){
        chartData = google.visualization.arrayToDataTable([
            ['Área','Avance Físico','% Ejecución'],
            <?php foreach($detalle['areas'] as $a): ?>
            ['<?= esc($a['nombre']) ?>', <?= floatval($a['avance_fisico']) ?>, <?= floatval($a['presupuesto_ejec']) ?>],
            <?php endforeach; ?>
        ]);
        titulo = 'Áreas';
    } else if(nivel==='unidad'){
        chartData = google.visualization.arrayToDataTable(dataUnidad);
        titulo = 'Unidades';
    } else {
        chartData = google.visualization.arrayToDataTable(dataOperacion);
        titulo = 'Operaciones';
    }
    options = {
        title: 'Drilldown por '+titulo,
        bars: 'horizontal',
        series: {
            0: { color:'#1976d2', targetAxisIndex:0 },
            1: { color:'#43a047', targetAxisIndex:1 }
        },
        hAxis: { minValue:0, maxValue:100, format:'#\'%\'' },
        vAxis: { textStyle:{fontSize:11} },
        chartArea:{width:'75%',height:'75%'}
    };
    var drillChart = new google.visualization.BarChart(document.getElementById('drilldown_chart'));
    drillChart.draw(chartData, options);
}

// Exportar dashboard a imagen
function exportImage() {
    html2canvas(document.getElementById('dashboard-main')).then(function(canvas) {
        var link = document.createElement("a");
        link.download = "dashboard-poa.png";
        link.href = canvas.toDataURL();
        link.click();
    });
}
// Exportar dashboard a PDF
function exportPDF() {
    html2canvas(document.getElementById('dashboard-main')).then(function(canvas) {
        var imgData = canvas.toDataURL('image/png');
        var pdf = new window.jspdf.jsPDF('l','mm','a4');
        var width = pdf.internal.pageSize.getWidth();
        var height = pdf.internal.pageSize.getHeight();
        pdf.addImage(imgData, 'PNG', 5, 5, width-10, height-10);
        pdf.save("dashboard-poa.pdf");
    });
}
window.onresize = drawAllCharts;
</script>
</body>
</html>