<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard POA: Sankey, Maps, Chart.js</title>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- Chart.js for extra charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .charts-row { display:flex; gap:2em; margin-bottom:2em;}
        .charts-row>div { flex:1; }
        .extra-charts { display:flex; gap:2em; }
        .extra-charts>div { flex:1; }
    </style>
</head>
<body>
<h2>Dashboard POA: Avanzado con Sankey, Mapas y Chart.js</h2>
<div class="charts-row">
    <div>
        <b>Flujo de Ejecución Presupuestaria por Área/Unidad (Sankey)</b>
        <div id="sankey_chart" style="width:100%;height:400px;"></div>
    </div>
    <div>
        <b>Mapa Geográfico de Avance Físico por Departamento</b>
        <div id="geo_chart" style="width:100%;height:400px;"></div>
    </div>
</div>
<div class="extra-charts">
    <div>
        <b>Comparativo Áreas (Barra animada, Chart.js)</b>
        <canvas id="chartjs_bar" width="400" height="340"></canvas>
    </div>
    <div>
        <b>Time Series Avance (Line Chart, Chart.js)</b>
        <canvas id="chartjs_line" width="400" height="340"></canvas>
    </div>
</div>
<script>
// Load Google Charts Sankey and GeoChart
google.charts.load('current', {'packages':['sankey','geochart']});
google.charts.setOnLoadCallback(drawSankeyMap);

function drawSankeyMap() {
    // Sankey Data: [From, To, Value]
    var sankeyData = new google.visualization.DataTable();
    sankeyData.addColumn('string', 'From');
    sankeyData.addColumn('string', 'To');
    sankeyData.addColumn('number', 'Value');
    sankeyData.addRows([
        ['Presupuesto', 'DRP',  3000000],
        ['Presupuesto', 'DAF',  4000000],
        ['Presupuesto', 'DBRAE',2000000],
        ['DRP', 'DRP-UC',  1800000],
        ['DRP', 'DRP-URC', 1200000],
        ['DAF', 'DAF-PLA', 1000000],
        ['DAF', 'DAF-UF',  2000000],
        ['DAF', 'DAF-UA',  1000000],
        ['DBRAE', 'DDBRAE-UDB', 1500000],
        ['DBRAE', 'DDBRAE-UL', 500000]
    ]);
    var sankeyChart = new google.visualization.Sankey(document.getElementById('sankey_chart'));
    sankeyChart.draw(sankeyData, {
        height: 360,
        node: { label: { fontSize: 13, color: '#444' }},
        link: { colorMode: 'gradient', colors: ['#1976d2','#43a047','#e53935']}
    });

    // GeoChart: avance físico por departamento (simulado)
    var geoData = google.visualization.arrayToDataTable([
        ['Departamento', 'Avance Físico (%)'],
        ['BO', 82], // Beni
        ['CB', 77], // Cochabamba
        ['CH', 68], // Chuquisaca
        ['LP', 92], // La Paz
        ['OR', 70], // Oruro
        ['PD', 55], // Pando
        ['PT', 60], // Potosí
        ['SC', 85], // Santa Cruz
        ['TJ', 50]  // Tarija
    ]);
    var geoChart = new google.visualization.GeoChart(document.getElementById('geo_chart'));
    geoChart.draw(geoData, {
        region: 'BO', // Bolivia
        resolution: 'provinces',
        colorAxis: {colors: ['#e53935','#fbc02d','#43a047','#1976d2']},
        backgroundColor: '#f4f8fb',
        datalessRegionColor: '#eeeeee'
    });
}

// Chart.js: Barra animada (Comparativo de áreas)
const ctxBar = document.getElementById('chartjs_bar').getContext('2d');
const barData = {
    labels: [
        <?php foreach($detalle['areas'] as $a){ echo "'".esc($a['nombre'])."',"; } ?>
    ],
    datasets: [{
        label: 'Avance Físico (%)',
        data: [<?php foreach($detalle['areas'] as $a){ echo floatval($a['avance_fisico']).','; } ?>],
        backgroundColor: [
            '#1976d2','#43a047','#e53935','#fbc02d','#8e24aa','#fb8c00','#3949ab','#00897b'
        ]
    }]
};
const barChart = new Chart(ctxBar, {
    type: 'bar',
    data: barData,
    options: {
        responsive:true,
        plugins: {
            legend: { display: false },
            title: { display: true, text: 'Avance Físico por Área' }
        },
        animation: {
            duration: 1800,
            easing: 'easeOutBounce'
        }
    }
});

// Chart.js: Time Series Line (Histórico simulado)
const ctxLine = document.getElementById('chartjs_line').getContext('2d');
const lineLabels = [<?php foreach($historico as $h){ echo "'".esc($h['periodo'])."',"; } ?>];
const lineDataSets = [
    <?php foreach($detalle['areas'] as $a): ?>
    {
      label: '<?= esc($a['nombre']) ?>',
      data: [<?php foreach($historico as $h){ echo floatval($h['areas'][$a['id']]['avance_fisico']).','; } ?>],
      borderColor: '#'+Math.floor(Math.random()*16777215).toString(16),
      fill:false
    },
    <?php endforeach; ?>
];
const lineChart = new Chart(ctxLine, {
    type: 'line',
    data: { labels: lineLabels, datasets: lineDataSets },
    options: {
        responsive:true,
        plugins: {
            legend: { position: 'bottom' },
            title: { display: true, text: 'Avance Físico Histórico por Área' }
        }
    }
});
</script>
</body>
</html>