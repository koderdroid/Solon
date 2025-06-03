<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard POA Avanzado</title>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- html2canvas & jsPDF for export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <style>
        .charts-row { display:flex; gap:2em; }
        .charts-row>div { flex:1; }
        .bar-panels { display:flex; gap:2em; }
        .bar-panels>div { flex:1; }
        .drilldown-panel { margin-top:2.2em;}
        .level-btns button { margin:0 5px 10px 0; border:none; background:#e3f2fd; color:#1976d2; padding:7px 16px; border-radius:7px; font-weight:bold; cursor:pointer;}
        .level-btns .active { background:#1976d2; color:#fff;}
        .export-btns { float:right; margin-top:-20px;}
        .export-btns button { margin-left:8px; border:none; background:#1976d2; color:#fff; padding:7px 16px; border-radius:7px; font-weight:bold; cursor:pointer;}
        .export-btns button:hover { background:#43a047;}
        .kpi-cards { display:flex; gap:1.2em; margin-bottom:2em;}
        .kpi-card { flex:1; background:linear-gradient(120deg,#e8f5e9,#e3f2fd); border-radius:9px; padding:1.2em; text-align:center; transition:box-shadow .2s;}
        .kpi-value { font-size:2em; font-weight:bold; color:#1976d2;}
    </style>
</head>
<body>
<div id="dashboard-main">
    <div class="kpi-cards">
        <div class="kpi-card"><div class="kpi-value"><?= round($kpis['avance_fisico_global'],2) ?>%</div>Avance Físico Global</div>
        <div class="kpi-card"><div class="kpi-value"><?= round($kpis['ejecucion_presupuestaria_global'],2) ?>%</div>% Ejecución Presupuestaria</div>
        <div class="kpi-card"><div class="kpi-value"><?= round($kpis['eficiencia_global'],2) ?></div>Índice de Eficiencia</div>
        <div class="kpi-card"><div class="kpi-value"><?= round($kpis['riesgo'],2) ?>%</div>Riesgo de Incumplimiento</div>
    </div>
    <div class="charts-row">
        <div id="gauge_avance_fisico" style="height:260px;"></div>
        <div id="gauge_eficiencia" style="height:260px;"></div>
    </div>
    <div class="bar-panels">
        <div>
            <div style="font-weight:bold; margin-bottom:.5em;">Avance Físico por Área</div>
            <div id="bar_avance_area" style="height:340px;"></div>
        </div>
        <div>
            <div style="font-weight:bold; margin-bottom:.5em;">Comparativo Histórico Avance Físico</div>
            <div id="area_timeseries" style="height:340px;"></div>
        </div>
    </div>
    <!-- Heatmap y Drilldown -->
    <div class="charts-row" style="margin-top:2em;">
        <div>
            <div style="font-weight:bold; margin-bottom:.5em;">Heatmap de Avance por Unidad y Trimestre</div>
            <div id="heatmap_unidad_trimestre" style="height:340px;"></div>
        </div>
        <div>
            <div class="level-btns">
                <button class="active" onclick="setLevel('area')">Nivel Área</button>
                <button onclick="setLevel('unidad')">Nivel Unidad</button>
                <button onclick="setLevel('operacion')">Nivel Operación</button>
            </div>
            <div id="drilldown_chart" style="height:340px;"></div>
        </div>
    </div>
    <div class="export-btns">
        <button onclick="exportImage()">Exportar Imagen</button>
        <button onclick="exportPDF()">Exportar PDF</button>
    </div>
</div>
<script>
google.charts.load('current', {'packages':['gauge','corechart','bar','timeline']});
google.charts.setOnLoadCallback(drawAllCharts);

let nivelActual='area';

function drawAllCharts() {
    // Velocímetros
    var gaugeData = google.visualization.arrayToDataTable([
        ['Label', 'Value'],
        ['Avance', <?= floatval($kpis['avance_fisico_global']) ?>]
    ]);
    var gaugeChart = new google.visualization.Gauge(document.getElementById('gauge_avance_fisico'));
    gaugeChart.draw(gaugeData, {min:0,max:100,greenFrom:80,greenTo:100,yellowFrom:60,yellowTo:80,redFrom:0,redTo:60,minorTicks:5,majorTicks:['0%','20%','40%','60%','80%','100%']});

    var gaugeData2 = google.visualization.arrayToDataTable([
        ['Label', 'Value'],
        ['Eficiencia', <?= floatval($kpis['eficiencia_global']) ?>]
    ]);
    var gaugeChart2 = new google.visualization.Gauge(document.getElementById('gauge_eficiencia'));
    gaugeChart2.draw(gaugeData2, {min:0,max:2,greenFrom:1.5,greenTo:2,yellowFrom:1, yellowTo:1.5,redFrom:0,redTo:1,minorTicks:5,majorTicks:['0','0.5','1','1.5','2']});

    // Barras avance por área
    var dataAvanceArea = google.visualization.arrayToDataTable([
        ['Área', 'Avance Físico (%)'],
        <?php foreach($detalle['areas'] as $a): ?>
        ['<?= esc($a['nombre']) ?>', <?= floatval($a['avance_fisico']) ?>],
        <?php endforeach; ?>
    ]);
    var chartAvanceArea = new google.visualization.BarChart(document.getElementById('bar_avance_area'));
    chartAvanceArea.draw(dataAvanceArea, {legend:{position:'none'},hAxis:{minValue:0,maxValue:100,format:'#\'%\''},chartArea:{width:'80%',height:'75%'}});

    // Comparativo histórico (time-series) (ejemplo simulado)
    var dataTime = google.visualization.arrayToDataTable([
        ['Periodo', <?php foreach($detalle['areas'] as $a){ echo "'".esc($a['nombre'])."',"; } ?>],
        <?php foreach($historico as $hist): ?>
        ['<?= esc($hist['periodo']) ?>', <?php foreach($detalle['areas'] as $a){ echo floatval($hist['areas'][$a['id']]['avance_fisico']) .','; } ?>],
        <?php endforeach; ?>
    ]);
    var chartAreaTime = new google.visualization.LineChart(document.getElementById('area_timeseries'));
    chartAreaTime.draw(dataTime, {title:'Avance Físico Histórico',curveType:'function',legend:{position:'bottom'}});

    // Heatmap (usando corechart ColumnChart con colores custom por valor)
    var dataHeat = google.visualization.arrayToDataTable([
        ['Unidad','1trim','2trim','3trim','4trim'],
        <?php foreach($detalle['unidades'] as $u): ?>
        ['<?= esc($u['nombre']) ?>', <?= floatval($u['t1']) ?>,<?= floatval($u['t2']) ?>,<?= floatval($u['t3']) ?>,<?= floatval($u['t4']) ?>],
        <?php endforeach; ?>
    ]);
    var optionsHeat = {
        title: 'Avance Físico por Unidad/Trimestre',
        colors: ['#d32f2f','#fbc02d','#388e3c','#1976d2'],
        isStacked:true,
        chartArea:{width:'70%',height:'70%'},
        legend:{position:'top'}
    };
    var chartHeat = new google.visualization.ColumnChart(document.getElementById('heatmap_unidad_trimestre'));
    chartHeat.draw(dataHeat, optionsHeat);

    // Drilldown inicial
    drawDrilldownChart(nivelActual);
}

// Drilldown AJAX example
function setLevel(nivel) {
    nivelActual = nivel;
    document.querySelectorAll('.level-btns button').forEach(btn => btn.classList.remove('active'));
    let idx = {area:0,unidad:1,operacion:2}[nivel];
    document.querySelectorAll('.level-btns button')[idx].classList.add('active');
    // AJAX: fetch new data per nivel
    fetch('/dashboardpoa/drilldown?nivel='+nivel)
      .then(resp=>resp.json())
      .then(data=>drawDrilldownChartWithData(data));
}
function drawDrilldownChartWithData(data) {
    var chartData = google.visualization.arrayToDataTable(data);
    var options = {
        bars: 'horizontal',
        series: {0:{color:'#1976d2'},1:{color:'#43a047'}},
        hAxis: { minValue:0, maxValue:100, format:'#\'%\'' },
        vAxis: { textStyle:{fontSize:11} },
        chartArea:{width:'75%',height:'75%'}
    };
    var drillChart = new google.visualization.BarChart(document.getElementById('drilldown_chart'));
    drillChart.draw(chartData, options);
}
function drawDrilldownChart(nivel) {
    // Data statically from PHP for initial load
    let chartData, options;
    if(nivel==='area'){
        chartData = google.visualization.arrayToDataTable([
            ['Área','Avance Físico','% Ejecución'],
            <?php foreach($detalle['areas'] as $a): ?>
            ['<?= esc($a['nombre']) ?>', <?= floatval($a['avance_fisico']) ?>, <?= floatval($a['presupuesto_ejec']) ?>],
            <?php endforeach; ?>
        ]);
    } else if(nivel==='unidad'){
        chartData = google.visualization.arrayToDataTable([
            ['Unidad','Avance Físico','% Ejecución'],
            <?php foreach($detalle['unidades'] as $u): ?>
            ['<?= esc($u['nombre']) ?>', <?= floatval($u['avance_fisico']) ?>, <?= floatval($u['presupuesto_ejec']) ?>],
            <?php endforeach; ?>
        ]);
    } else {
        chartData = google.visualization.arrayToDataTable([
            ['Operación','Avance Físico','% Ejecución'],
            <?php foreach($detalle['operaciones'] as $o): ?>
            ['<?= esc($o['nombre']) ?>', <?= floatval($o['avance_fisico']) ?>, <?= floatval($o['presupuesto_ejec']) ?>],
            <?php endforeach; ?>
        ]);
    }
    options = {
        bars: 'horizontal',
        series: {0:{color:'#1976d2'},1:{color:'#43a047'}},
        hAxis: { minValue:0, maxValue:100, format:'#\'%\'' },
        vAxis: { textStyle:{fontSize:11} },
        chartArea:{width:'75%',height:'75%'}
    };
    var drillChart = new google.visualization.BarChart(document.getElementById('drilldown_chart'));
    drillChart.draw(chartData, options);
}

function exportImage() {
    html2canvas(document.getElementById('dashboard-main')).then(function(canvas) {
        var link = document.createElement("a");
        link.download = "dashboard-poa.png";
        link.href = canvas.toDataURL();
        link.click();
    });
}
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