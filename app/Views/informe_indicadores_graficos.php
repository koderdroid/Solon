<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Informe Gráfico de Indicadores</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/css/bootstrap.min.css">
    <style>
        body { background: #f7fafd; }
        .main-title { font-size:1.35em; color:#1976d2; font-weight:bold;}
        .chart-container { background: #fff; border-radius:10px; margin-bottom:1.3em; box-shadow:0 2px 8px #eaf1fa; padding:1em;}
        .table th, .table td { font-size:0.98em;}
        .pdf-btn { float:right; margin-left:1em;}
        .comentario-box { font-size:0.98em; color: #1976d2; margin-top:0.5em; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</head>
<body>
<div class="container-xl mt-3 mb-3" id="informe-indicadores-main">
    <div class="main-title mb-3">
        Informe Gráfico de Indicadores
        <button class="btn btn-danger pdf-btn" onclick="exportToPDF()">Exportar PDF</button>
        <button class="btn btn-primary pdf-btn" onclick="window.print()">Imprimir</button>
    </div>

    <!-- 1. Evolución del Grado de Cumplimiento de la DEJURBE -->
    <div class="chart-container mb-3">
        <div style="font-weight:bold; color:#1976d2;">Evolución del Grado de Cumplimiento de la DEJURBE (cantidades y %)</div>
        <canvas id="grafico_cumplimiento_dejurbe" height="120"></canvas>
        <div class="table-responsive mt-2">
        <table class="table table-sm table-bordered align-middle mb-0">
            <thead>
                <tr>
                    <th>Gestión</th>
                    <th>Universo Entidades</th>
                    <th>Declararon</th>
                    <th>% Declaración</th>
                    <th>Incremento %</th>
                    <th>Certificaciones DEJURBE</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($cumplimiento_dejurbe as $fila): ?>
                <tr>
                    <td><?= esc($fila['gestion']) ?></td>
                    <td><?= esc($fila['universo']) ?></td>
                    <td><?= esc($fila['declararon']) ?></td>
                    <td><?= esc($fila['porc_declaracion']) ?></td>
                    <td><?= esc($fila['incremento']) ?></td>
                    <td><?= esc($fila['certificaciones']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        <div class="comentario-box">Espacios para comentarios y aclaración del Gráfico y Cuadro</div>
    </div>

    <!-- 2. Situación de derecho propietario de Inmuebles -->
    <div class="chart-container mb-3">
        <div style="font-weight:bold; color:#1976d2;">Situación de derecho propietario de Inmuebles, por gestiones (en cantidades)</div>
        <canvas id="grafico_inmuebles" height="120"></canvas>
        <div class="table-responsive mt-2">
        <table class="table table-sm table-bordered align-middle mb-0">
            <thead>
                <tr>
                    <th>Gestión</th>
                    <th>Definitivo (Folio Real)</th>
                    <th>Otro Documento</th>
                    <th>Sin Documento</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($inmuebles as $fila): ?>
                <tr>
                    <td><?= esc($fila['gestion']) ?></td>
                    <td><?= esc($fila['definitivo']) ?></td>
                    <td><?= esc($fila['otro']) ?></td>
                    <td><?= esc($fila['sin']) ?></td>
                    <td><?= esc($fila['total']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        <div class="comentario-box">Espacios para comentarios y aclaración del Gráfico y Cuadro</div>
    </div>

    <!-- 3. Situación de derecho propietario del Parque Automotor -->
    <div class="chart-container mb-3">
        <div style="font-weight:bold; color:#1976d2;">Situación de derecho propietario del Parque Automotor, por gestiones (en cantidades)</div>
        <canvas id="grafico_parque" height="120"></canvas>
        <div class="table-responsive mt-2">
        <table class="table table-sm table-bordered align-middle mb-0">
            <thead>
                <tr>
                    <th>Gestión</th>
                    <th>Definitivo (RUAT)</th>
                    <th>Otro Documento</th>
                    <th>Sin Documento</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($parque as $fila): ?>
                <tr>
                    <td><?= esc($fila['gestion']) ?></td>
                    <td><?= esc($fila['definitivo']) ?></td>
                    <td><?= esc($fila['otro']) ?></td>
                    <td><?= esc($fila['sin']) ?></td>
                    <td><?= esc($fila['total']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        <div class="comentario-box">Espacios para comentarios y aclaración del Gráfico y Cuadro</div>
    </div>

    <!-- 4. Certificaciones SICEPA y CIBID, por gestiones -->
    <div class="chart-container mb-3">
        <div style="font-weight:bold; color:#1976d2;">Certificaciones emitidas SICEPA y CIBID, por gestiones</div>
        <div class="row">
            <div class="col-md-6">
                <canvas id="grafico_sicepa" height="100"></canvas>
                <div class="table-responsive mt-2">
                <table class="table table-sm table-bordered align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Gestión</th>
                            <th>Certificaciones SICEPA</th>
                            <th>Entidades Beneficiadas</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($sicepa as $fila): ?>
                        <tr>
                            <td><?= esc($fila['gestion']) ?></td>
                            <td><?= esc($fila['certificaciones']) ?></td>
                            <td><?= esc($fila['entidades']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
            </div>
            <div class="col-md-6">
                <canvas id="grafico_cibid" height="100"></canvas>
                <div class="table-responsive mt-2">
                <table class="table table-sm table-bordered align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Gestión</th>
                            <th>Certificaciones CIBID</th>
                            <th>Entidades Beneficiadas</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($cibid as $fila): ?>
                        <tr>
                            <td><?= esc($fila['gestion']) ?></td>
                            <td><?= esc($fila['certificaciones']) ?></td>
                            <td><?= esc($fila['entidades']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
        <div class="comentario-box">Espacios para comentarios y aclaración del Gráfico y Cuadro</div>
    </div>

    <!-- 5. Recuperaciones y monetización de activos -->
    <div class="chart-container mb-3">
        <div style="font-weight:bold; color:#1976d2;">Recuperaciones y monetización de activos por gestiones (millones Bs)</div>
        <canvas id="grafico_recuperaciones" height="120"></canvas>
        <div class="table-responsive mt-2">
        <table class="table table-sm table-bordered align-middle mb-0">
            <thead>
                <tr>
                    <th>Gestión</th>
                    <th>Acumulado (Bs)</th>
                    <th>Recuperaciones adeudos</th>
                    <th>Transferencia de bienes</th>
                    <th>Depósito retención judicial</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($recuperaciones as $fila): ?>
                <tr>
                    <td><?= esc($fila['gestion']) ?></td>
                    <td><?= esc($fila['acumulado']) ?></td>
                    <td><?= esc($fila['recuperaciones']) ?></td>
                    <td><?= esc($fila['transferencia']) ?></td>
                    <td><?= esc($fila['deposito']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        <div class="comentario-box">Espacios para comentarios y aclaración del Gráfico y Cuadro</div>
    </div>
</div>
<script>
// === Datos de ejemplo: reemplazar por backend dinámico ===
const cumplimientoDejurbe = <?= json_encode(array_map(fn($f)=>[
    'gestion'=>$f['gestion'],
    'universo'=>$f['universo'],
    'declararon'=>$f['declararon'],
    'porc_declaracion'=>floatval(str_replace(',','.',$f['porc_declaracion'])),
    'incremento'=>floatval(str_replace(',','.',$f['incremento'])),
    'certificaciones'=>$f['certificaciones']
], $cumplimiento_dejurbe)) ?>;

const inmuebles = <?= json_encode($inmuebles) ?>;
const parque = <?= json_encode($parque) ?>;
const sicepa = <?= json_encode($sicepa) ?>;
const cibid = <?= json_encode($cibid) ?>;
const recuperaciones = <?= json_encode($recuperaciones) ?>;

// 1. Cumplimiento DEJURBE
new Chart(document.getElementById('grafico_cumplimiento_dejurbe').getContext('2d'), {
    type: 'bar',
    data: {
        labels: cumplimientoDejurbe.map(x=>x.gestion),
        datasets: [
            {
                label: '% Declaración',
                data: cumplimientoDejurbe.map(x=>x.porc_declaracion),
                backgroundColor: '#1565c0'
            },
            {
                label: 'Incremento %',
                data: cumplimientoDejurbe.map(x=>x.incremento),
                type:'line',
                borderColor: '#fbc02d',
                backgroundColor: 'rgba(251,192,45,0.15)',
                yAxisID: 'y2'
            }
        ]
    },
    options: {
        plugins: {
            legend: { position:'top' },
            datalabels: { display:true, anchor:'center', color:'#1565c0', font:{weight:'bold'}, formatter:v=>v+'%' }
        },
        scales: {
            y: { min:90, max:102, title:{display:true,text:'%'}},
            y2: { min:-2, max:3, position:'right', grid:{drawOnChartArea:false}, title:{display:true,text:'Incremento %'} }
        }
    },
    plugins: [ChartDataLabels]
});

// 2. Inmuebles por gestión
new Chart(document.getElementById('grafico_inmuebles').getContext('2d'), {
    type: 'bar',
    data: {
        labels: inmuebles.map(x=>x.gestion),
        datasets: [
            {label:'Definitivo',data:inmuebles.map(x=>x.definitivo),backgroundColor:'#1976d2'},
            {label:'Otro Documento',data:inmuebles.map(x=>x.otro),backgroundColor:'#64b5f6'},
            {label:'Sin Documento',data:inmuebles.map(x=>x.sin),backgroundColor:'#bdbdbd'}
        ]
    },
    options: {
        plugins: { legend: { position:'top' }, datalabels: { display:false } },
        scales: { y: { beginAtZero:true } }
    }
});

// 3. Parque automotor por gestión
new Chart(document.getElementById('grafico_parque').getContext('2d'), {
    type: 'bar',
    data: {
        labels: parque.map(x=>x.gestion),
        datasets: [
            {label:'Definitivo',data:parque.map(x=>x.definitivo),backgroundColor:'#43a047'},
            {label:'Otro Documento',data:parque.map(x=>x.otro),backgroundColor:'#a5d6a7'},
            {label:'Sin Documento',data:parque.map(x=>x.sin),backgroundColor:'#bdbdbd'}
        ]
    },
    options: {
        plugins: { legend:{ position:'top' }, datalabels:{ display:false } },
        scales: { y:{ beginAtZero:true } }
    }
});

// 4. Certificaciones SICEPA y CIBID
new Chart(document.getElementById('grafico_sicepa').getContext('2d'), {
    type:'bar',
    data:{
        labels: sicepa.map(x=>x.gestion),
        datasets:[
            {label:'Certificaciones SICEPA', data:sicepa.map(x=>x.certificaciones), backgroundColor:'#1976d2'},
            {label:'Entidades Beneficiadas', data:sicepa.map(x=>x.entidades), backgroundColor:'#fbc02d', type:'line', yAxisID:'y2'}
        ]
    },
    options:{
        plugins:{ legend:{position:'top'}, datalabels:{display:true,anchor:'center',color:'#1976d2',font:{weight:'bold'}} },
        scales:{ y:{beginAtZero:true}, y2:{position:'right',grid:{drawOnChartArea:false}} }
    },
    plugins:[ChartDataLabels]
});
new Chart(document.getElementById('grafico_cibid').getContext('2d'), {
    type:'bar',
    data:{
        labels: cibid.map(x=>x.gestion),
        datasets:[
            {label:'Certificaciones CIBID', data:cibid.map(x=>x.certificaciones), backgroundColor:'#43a047'},
            {label:'Entidades Beneficiadas', data:cibid.map(x=>x.entidades), backgroundColor:'#fbc02d', type:'line', yAxisID:'y2'}
        ]
    },
    options:{
        plugins:{ legend:{position:'top'}, datalabels:{display:true,anchor:'center',color:'#43a047',font:{weight:'bold'}} },
        scales:{ y:{beginAtZero:true}, y2:{position:'right',grid:{drawOnChartArea:false}} }
    },
    plugins:[ChartDataLabels]
});

// 5. Recuperaciones y monetización de activos
new Chart(document.getElementById('grafico_recuperaciones').getContext('2d'), {
    type: 'bar',
    data: {
        labels: recuperaciones.map(x=>x.gestion),
        datasets: [
            {label:'Acumulado (Bs)',data:recuperaciones.map(x=>parseFloat(x.acumulado.replace('.','').replace(',','.'))/1e6),backgroundColor:'#1976d2'}
        ]
    },
    options: {
        plugins: { legend:{position:'top'}, datalabels:{display:true,anchor:'end',color:'#1976d2',font:{weight:'bold'},formatter:v=>v.toFixed(2)+' M'} },
        scales: { y:{beginAtZero:true,title:{display:true,text:'Millones Bs'}} }
    },
    plugins:[ChartDataLabels]
});

// Exportar a PDF
function exportToPDF() {
    const element = document.getElementById('informe-indicadores-main');
    html2pdf().set({
        margin:       0.5,
        filename:     'informe-indicadores.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2, useCORS: true },
        jsPDF:        { unit: 'in', format: 'a4', orientation: 'landscape' }
    }).from(element).save();
}
</script>
</body>
</html>