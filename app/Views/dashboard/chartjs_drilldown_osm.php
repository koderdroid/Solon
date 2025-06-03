<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard POA: Drilldown Chart.js y Mapas OpenStreetMap</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Chart.js Plugin for clickable bars: chartjs-plugin-datalabels (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <!-- Leaflet.js for OpenStreetMap -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <style>
        .dashboard-row { display: flex; gap:3em; margin-bottom:2em;}
        .dashboard-row > div { flex:1; }
        #osm_map { width: 100%; height: 410px; border-radius: 12px; }
        .legend-label { font-size:0.95em; margin-top:6px;}
    </style>
</head>
<body>
<h2>Dashboard POA: Drilldown Interactivo (Chart.js) y Mapa OSM</h2>
<div class="dashboard-row">
    <div>
        <b id="drill-title">Avance Físico Global por Área</b>
        <canvas id="drilldown_chart" width="420" height="380"></canvas>
        <div class="legend-label" id="drill-legend"></div>
    </div>
    <div>
        <b>Ubicación de Áreas/Unidades en el Territorio (OpenStreetMap)</b>
        <div id="osm_map"></div>
    </div>
</div>
<script>
// Drilldown Chart.js
let chartDataLevels = {
    area: {
        labels: [<?php foreach($detalle['areas'] as $a){ echo "'".esc($a['nombre'])."',"; } ?>],
        data: [<?php foreach($detalle['areas'] as $a){ echo floatval($a['avance_fisico']).','; } ?>],
        color: '#1976d2'
    },
    unidad: {
        labels: [<?php foreach($detalle['unidades'] as $u){ echo "'".esc($u['nombre'])."',"; } ?>],
        data: [<?php foreach($detalle['unidades'] as $u){ echo floatval($u['avance_fisico']).','; } ?>],
        color: '#43a047'
    },
    operacion: {
        labels: [<?php foreach($detalle['operaciones'] as $o){ echo "'".esc($o['nombre'])."',"; } ?>],
        data: [<?php foreach($detalle['operaciones'] as $o){ echo floatval($o['avance_fisico']).','; } ?>],
        color: '#fb8c00'
    }
};
let currentLevel = 'area';

function renderDrilldownChart(level) {
    currentLevel = level;
    document.getElementById('drill-title').innerText = (
        level==='area'?'Avance Físico Global por Área':
        (level==='unidad'?'Avance Físico por Unidad':'Avance Físico por Operación')
    );
    document.getElementById('drill-legend').innerText = (
        level==='area'?'Haz clic en una barra para ver detalle por Unidad':
        (level==='unidad'?'Haz clic para ver detalle por Operación':'Volver arriba con el botón')
    );
    let ctx = document.getElementById('drilldown_chart').getContext('2d');
    if(window.drillChart) window.drillChart.destroy();
    window.drillChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartDataLevels[level].labels,
            datasets: [{
                label: 'Avance Físico (%)',
                data: chartDataLevels[level].data,
                backgroundColor: chartDataLevels[level].color,
                datalabels: { anchor: 'end', align: 'end' }
            }]
        },
        options: {
            plugins: {
                datalabels: { color:'#222', formatter: v=>v+'%', font:{ weight:'bold' } }
            },
            onClick: function(e, elements) {
                if(elements.length > 0) {
                    if(level==='area') renderDrilldownChart('unidad');
                    else if(level==='unidad') renderDrilldownChart('operacion');
                }
            },
            scales: {
                y: { beginAtZero: true, max: 100, ticks:{ callback:(v)=>v+'%' } }
            }
        },
        plugins: [ChartDataLabels]
    });
}
renderDrilldownChart(currentLevel);

// OpenStreetMap with Leaflet: Example with dummy markers for areas/unidades
var map = L.map('osm_map').setView([-17.4, -66.2], 5); // Bolivia center
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

// Example: marker for each unidad (replace with dynamic data as needed)
<?php
// Example coordinates for demonstration, replace with real ones in production
$unidad_coords = [
    'DCB-DCB'=>[-17.390, -66.160], // Cochabamba
    'DOR-DOR'=>[-17.980, -67.110], // Oruro
    'DSC-DSC'=>[-17.780, -63.180], // Santa Cruz
    'DCH-DCH'=>[-19.050, -65.260], // Chuquisaca
    'DBE-DBE'=>[-11.000, -66.000], // Beni
    'DAF-PLA'=>[-16.500, -68.150], // La Paz
];
foreach($detalle['unidades'] as $u) {
    $coord = $unidad_coords[$u['id']] ?? [-16.5, -68.15];
    $name = esc($u['nombre']);
    $avance = floatval($u['avance_fisico']);
    echo "L.marker([".$coord[0].",".$coord[1]."]).addTo(map).bindPopup('<b>$name</b><br>Avance: $avance%');\n";
}
?>
</script>
</body>
</html>