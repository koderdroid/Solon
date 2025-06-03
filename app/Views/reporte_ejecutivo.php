<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte Ejecutivo SENAPE</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/css/bootstrap.min.css">
    <style>
        body { background: #f7fafd; }
        .kpi-trend { font-size:1.5em; vertical-align:middle; }
        .kpi-up { color:#43a047;}
        .kpi-down { color:#e53935;}
        .kpi-same { color:#888;}
        .kpi-bar-label { font-weight: bold;}
        .kpi-bar-value { font-size:1.3em;}
        .kpi-bar .progress {height:1.5em;}
        .chart-container { padding: 0.7em 1em 0.5em 1em; background:#fff; border-radius:10px; margin-bottom:1.2em; box-shadow:0 2px 8px #eee;}
        .indicador-title { color:#1976d2; font-size:1.1em; font-weight:bold;}
        .indicador-desc { font-size:0.96em; }
        .desc-tendencia { font-size:0.97em; margin-top:.4em;}
        .main-title { font-size:1.3em; font-weight:bold; color:#1976d2;}
        .logo-senape { float:right; width:110px; margin-top:-25px;}
        .pdf-btn { float:right; margin:0 0 1em 1em; }
    </style>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- html2pdf.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</head>
<body>
<div class="container-xl mt-3 mb-3" id="reporte-ejecutivo-main">
    <img src="/assets/logo-senape.png" class="logo-senape" alt="SENAPE logo">
    <div class="main-title mb-2">
        Seguimiento y Evaluación al Plan Operativo Anual — SENAPE<br>
        <span style="font-size:0.9em">Al <?= date("d \d\\e F \d\\e Y") ?></span>
        <button class="btn btn-danger pdf-btn" onclick="exportToPDF()">Exportar PDF</button>
        <button class="btn btn-primary pdf-btn" onclick="window.print()">Imprimir</button>
    </div>

    <!-- Indicador: Avance Físico y Financiero -->
    <div class="row g-2">
        <div class="col-lg-6">
            <div class="chart-container">
                <div class="indicador-title">Avance Físico y Financiero SENAPE</div>
                <div class="row mt-2">
                    <div class="col-7">
                        <div class="kpi-bar-label">Avance Físico</div>
                        <div class="progress mb-2"><div class="progress-bar bg-danger" style="width:<?= $kpis['fisico'] ?>%"><?= $kpis['fisico'] ?>%</div></div>
                        <div class="kpi-bar-label">Avance Financiero</div>
                        <div class="progress"><div class="progress-bar bg-primary" style="width:<?= $kpis['financiero'] ?>%"><?= $kpis['financiero'] ?>%</div></div>
                    </div>
                    <div class="col-5 text-end">
                        <?= tendencia_flecha($kpis['fisico_tendencia']) ?>
                        <span class="kpi-bar-value"><?= $kpis['fisico'] ?>%</span>
                        <?= tendencia_flecha($kpis['financiero_tendencia']) ?>
                        <span class="kpi-bar-value"><?= $kpis['financiero'] ?>%</span>
                        <div class="desc-tendencia"><?= $kpis['comentario_tendencia'] ?></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Indicador: Recursos Económicos -->
        <div class="col-lg-6">
            <div class="chart-container">
                <div class="indicador-title">Generación de recursos Económicos a favor del TGN (MM Bs)</div>
                <canvas id="bar_recursos"></canvas>
                <div class="desc-tendencia"><?= $indicadores['recursos']['descripcion'] ?></div>
            </div>
        </div>
    </div>

    <!-- Indicadores adicionales en cards -->
    <div class="row g-2">
        <div class="col-lg-6">
            <div class="chart-container">
                <div class="indicador-title">Certificaciones SICEPA (cantid.)</div>
                <canvas id="bar_sicepa"></canvas>
                <div class="desc-tendencia"><?= $indicadores['sicepa']['descripcion'] ?></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="chart-container">
                <div class="indicador-title">Certificaciones CIBID (cantid.)</div>
                <canvas id="bar_cibid"></canvas>
                <div class="desc-tendencia"><?= $indicadores['cibid']['descripcion'] ?></div>
            </div>
        </div>
    </div>
    <!-- Puede agregar más cards/indicadores aquí -->
</div>
<script>
// Flecha de tendencia (se puede mejorar con SVG)
function tendencia_flecha(t) {
    if(t>0) return '<span class="kpi-trend kpi-up">&#8593;</span>';
    if(t<0) return '<span class="kpi-trend kpi-down">&#8595;</span>';
    return '<span class="kpi-trend kpi-same">&#8596;</span>';
}

// Cargar los datos desde PHP dinámicamente
const recursosLabels = <?= json_encode($indicadores['recursos']['labels']) ?>;
const recursosData = <?= json_encode($indicadores['recursos']['values']) ?>;
const sicepaLabels = <?= json_encode($indicadores['sicepa']['labels']) ?>;
const sicepaData = <?= json_encode($indicadores['sicepa']['values']) ?>;
const cibidLabels = <?= json_encode($indicadores['cibid']['labels']) ?>;
const cibidData = <?= json_encode($indicadores['cibid']['values']) ?>;

// Chart.js - Recursos Económicos
new Chart(document.getElementById('bar_recursos').getContext('2d'), {
    type: 'bar',
    data: {
        labels: recursosLabels,
        datasets: [{
            label: 'MM Bs',
            data: recursosData,
            backgroundColor: ['#1976d2','#43a047','#e53935','#fbc02d','#8e24aa','#fb8c00','#3949ab','#00897b']
        }]
    },
    options: {
        plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: ctx => ctx.formattedValue+' MM Bs' } }
        },
        animation: { duration: 1300, easing: 'easeOutBounce' },
        scales: { y: { beginAtZero: true } }
    }
});

// Chart.js - SICEPA
new Chart(document.getElementById('bar_sicepa').getContext('2d'), {
    type: 'bar',
    data: {
        labels: sicepaLabels,
        datasets: [{
            label: 'Certificados',
            data: sicepaData,
            backgroundColor: '#43a047'
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        animation: { duration: 900, easing: 'easeOutBounce' },
        scales: { y: { beginAtZero: true } }
    }
});

// Chart.js - CIBID
new Chart(document.getElementById('bar_cibid').getContext('2d'), {
    type: 'bar',
    data: {
        labels: cibidLabels,
        datasets: [{
            label: 'Certificados',
            data: cibidData,
            backgroundColor: '#1976d2'
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        animation: { duration: 900, easing: 'easeOutBounce' },
        scales: { y: { beginAtZero: true } }
    }
});

// Exportar a PDF con html2pdf
function exportToPDF() {
    const element = document.getElementById('reporte-ejecutivo-main');
    html2pdf().set({
        margin:       0.5,
        filename:     'reporte-ejecutivo-senape.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2, useCORS: true },
        jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
    }).from(element).save();
}
</script>
</body>
</html>