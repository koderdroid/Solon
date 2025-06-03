<!-- ...encabezado y estilos previos... -->
<div class="main-title mb-2">
    Cuadro N° 1: Resultados y/o desviaciones<br>
    <small>Al <?= date("d \d\\e F \d\\e Y") ?> — Periodo: <?= esc($periodo) ?></small>
    <button class="btn btn-danger float-end" onclick="exportToPDF()">Exportar PDF</button>
    <button class="btn btn-primary float-end me-2" onclick="window.print()">Imprimir</button>
</div>
<table class="table table-bordered align-middle" id="alertas-table">
    <thead>
        <tr class="table-secondary">
            <th>Unidad</th>
            <th>Área</th>
            <th>% Avance<br><small>(calculado)</small></th>
            <th>% Avance<br><small>(reportado)</small></th>
            <th>% Ejecución<br><small>(calculado)</small></th>
            <th>% Ejecución<br><small>(reportado)</small></th>
            <th>% Eficiencia<br><small>(calculado)</small></th>
            <th>% Eficiencia<br><small>(reportado)</small></th>
            <th>Personas Discapacidad</th>
            <th>Resultados</th>
            <th>Desviaciones</th>
            <th>Alertas</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($cruzado as $r): 
            $tr_class = (!empty($r['alertas'])) ? "fuera-rango" : "ok-rango"; ?>
        <tr class="<?= $tr_class ?>" data-alertas="<?= htmlspecialchars(json_encode($r['alertas'])) ?>">
            <td><?= esc($r['unidad_nombre']) ?></td>
            <td><?= esc($r['area_nombre']) ?></td>
            <td><?= isset($r['indicadores']['avance_fisico_real']) ? round($r['indicadores']['avance_fisico_real'],2).'%' : '-' ?></td>
            <td><?= isset($r['avance_fisico']) ? round($r['avance_fisico'],2).'%' : '-' ?></td>
            <td><?= isset($r['indicadores']['ejecucion_real']) ? round($r['indicadores']['ejecucion_real'],2).'%' : '-' ?></td>
            <td><?= isset($r['ejec_presupuestaria']) ? round($r['ejec_presupuestaria'],2).'%' : '-' ?></td>
            <td><?= isset($r['indicadores']['eficiencia_real']) ? round($r['indicadores']['eficiencia_real'],2) : '-' ?></td>
            <td><?= isset($r['eficiencia']) ? round($r['eficiencia'],2) : '-' ?></td>
            <td><?= esc($r['personas_discapacidad']) ?></td>
            <td style="white-space:pre-line"><?= esc($r['resultados']) ?></td>
            <td style="white-space:pre-line"><?= esc($r['desviaciones']) ?></td>
            <td>
                <?php if (!empty($r['alertas'])): foreach($r['alertas'] as $a): ?>
                    <div class="alerta-indicador"><?= esc($a) ?></div>
                <?php endforeach; endif; ?>
                <?php if (!empty($r['sugerencia_desviacion'])): ?>
                    <div class="sugerencia-desviacion"><?= esc($r['sugerencia_desviacion']) ?></div>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<!-- Dashboard visual para navegar por las alertas -->
<div class="mt-4">
    <div id="chart_alertas" style="width:100%;height:420px;"></div>
</div>
<script src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
function exportToPDF() { /* ...igual que antes... */ }

// Google Charts: Alertas por unidad
google.charts.load('current', {packages:['bar']});
google.charts.setOnLoadCallback(drawAlertasChart);

function drawAlertasChart() {
    // Genera series de alertas por unidad para navegación
    let table = document.getElementById('alertas-table');
    let rows = table.querySelectorAll('tbody tr');
    let data = [['Unidad','Cantidad Alertas']];
    let mapUnidad = {};
    rows.forEach(row=>{
        let unidad = row.children[0].innerText;
        let alertas = JSON.parse(row.dataset.alertas || '[]');
        data.push([unidad, alertas.length]);
        mapUnidad[unidad] = row;
    });
    let chartData = google.visualization.arrayToDataTable(data);
    let chart = new google.charts.Bar(document.getElementById('chart_alertas'));
    chart.draw(chartData, {
        legend: {position:'none'},
        bars:'horizontal',
        colors:['#e53935'],
        chartArea:{width:'80%',height:'70%'},
        title:'Unidades con alertas / desviaciones'
    });
    // Interactividad: click en barra desplaza al detalle de la fila
    google.visualization.events.addListener(chart, 'select', function() {
        let selection = chart.getSelection();
        if(selection.length>0) {
            let rowIdx = selection[0].row+1; // +1 por encabezado
            let unidad = data[rowIdx][0];
            let tr = mapUnidad[unidad];
            tr.scrollIntoView({behavior:'smooth',block:'center'});
            tr.classList.add('table-warning');
            setTimeout(()=>tr.classList.remove('table-warning'),2000);
        }
    });
}
</script>