<?php
// $areas: [ [area_id, area_nombre, avance_fisico, presupuesto_vigente, presupuesto_ejecutado, porcentaje_ejecucion_presupuestaria], ... ]
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Consolidado POA</title>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <style>
        .charts-row { display: flex; gap:2em; }
        .charts-row > div { flex:1; }
    </style>
</head>
<body>
    <h2>Dashboard Consolidado por Área - Periodo <?= esc($periodo) ?></h2>
    <div class="charts-row">
        <div id="grafico_avance_fisico" style="width:100%;height:340px;"></div>
        <div id="grafico_ejecucion_presupuestaria" style="width:100%;height:340px;"></div>
    </div>
    <table border="1" style="width:100%;margin-top:20px;">
        <thead>
            <tr>
                <th>Área</th>
                <th>Avance físico (%)</th>
                <th>Presupuesto Vigente</th>
                <th>Presupuesto Ejecutado</th>
                <th>% Ejecución presupuestaria</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($areas as $a): ?>
                <tr>
                    <td><?= esc($a['area_nombre']) ?></td>
                    <td><?= esc($a['avance_fisico']) ?></td>
                    <td><?= number_format($a['presupuesto_vigente'],2) ?></td>
                    <td><?= number_format($a['presupuesto_ejecutado'],2) ?></td>
                    <td><?= esc($a['porcentaje_ejecucion_presupuestaria']) ?>%</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<script>
google.charts.load('current', {packages:['corechart','bar']});
google.charts.setOnLoadCallback(drawCharts);
function drawCharts() {
    // Avance físico por área
    var dataAvance = google.visualization.arrayToDataTable([
        ['Área', 'Avance físico (%)'],
        <?php foreach($areas as $a): ?>
        ['<?= esc($a['area_nombre']) ?>', <?= floatval($a['avance_fisico']) ?>],
        <?php endforeach; ?>
    ]);
    var optionsAvance = {
        title: 'Avance Físico (%) por Área',
        legend: { position: 'none' },
        hAxis: { minValue: 0, maxValue: 100, format: '#\'%\'' }
    };
    var chartAvance = new google.visualization.BarChart(document.getElementById('grafico_avance_fisico'));
    chartAvance.draw(dataAvance, optionsAvance);

    // Ejecución presupuestaria por área
    var dataPres = google.visualization.arrayToDataTable([
        ['Área', '% Ejecución'],
        <?php foreach($areas as $a): ?>
        ['<?= esc($a['area_nombre']) ?>', <?= floatval($a['porcentaje_ejecucion_presupuestaria']) ?>],
        <?php endforeach; ?>
    ]);
    var optionsPres = {
        title: '% Ejecución Presupuestaria por Área',
        legend: { position: 'none' },
        hAxis: { minValue: 0, maxValue: 100, format: '#\'%\'' }
    };
    var chartPres = new google.visualization.BarChart(document.getElementById('grafico_ejecucion_presupuestaria'));
    chartPres.draw(dataPres, optionsPres);
}
</script>
</body>
</html>