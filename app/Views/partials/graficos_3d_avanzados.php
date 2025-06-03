<!-- Gráficos tipo 3D avanzados (estilo imágenes 7 y 8) usando Chart.js + plugin de bordes y gradientes -->
<div class="chart-container mb-3">
  <div class="mb-2" style="font-weight:bold; color:#1976d2;">Cumplimiento Físico y Financiero por Unidad/Área (barras avanzadas)</div>
  <canvas id="bar3d_fisico_financiero" height="120"></canvas>
</div>
<div class="chart-container mb-3">
  <div class="mb-2" style="font-weight:bold; color:#1976d2;">Eficiencia relativa por Unidad/Área (barras avanzadas)</div>
  <canvas id="bar3d_eficiencia" height="120"></canvas>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script>
function grad3D(ctx, colorA, colorB) {
    var grad = ctx.createLinearGradient(0, 0, 0, 180);
    grad.addColorStop(0, colorA); grad.addColorStop(1, colorB);
    return grad;
}

// Datos ejemplo, reemplaza por los de tu backend dinámico:
const labelsUnidades = [
  "DRP", "DAF", "DBRAE", "Transparencia", "Apoyo", "Sustantivas", "Unidad 7", "Unidad 8", "Unidad 9", "Unidad 10", "Unidad 11", "Unidad 12", "Unidad 13", "Unidad 14", "Unidad 15"
];
const avanceFisico = [97.16, 97.36, 100, 97.66, 99.27, 99.36, 100, 100, 97.99, 97.59, 89.54, 100, 99.95, 96.93, 97.92];
const avanceFinanciero = [98.24, 96.32, 100, 96.66, 97.92, 97.16, 100, 81.89, 100, 100, 100, 100, 96.08, 99.32, 100];

// Gráfico 3D físico-financiero
var ctxBar3D = document.getElementById('bar3d_fisico_financiero').getContext('2d');
var barColorsFisico = grad3D(ctxBar3D, "#1976d2", "#64b5f6");
var barColorsFinanciero = grad3D(ctxBar3D, "#fb8c00", "#ffe082");

new Chart(ctxBar3D, {
    type: 'bar',
    data: {
        labels: labelsUnidades,
        datasets: [
            {
                label: 'Avance Físico',
                data: avanceFisico,
                backgroundColor: barColorsFisico,
                borderColor: "#0d47a1",
                borderWidth: 2,
                datalabels: {
                    anchor: 'end', align: 'end', color:'#1976d2', font:{weight:'bold'}, formatter:v=>v.toFixed(2)
                }
            },
            {
                label: 'Avance Financiero',
                data: avanceFinanciero,
                backgroundColor: barColorsFinanciero,
                borderColor: "#f57c00",
                borderWidth: 2,
                datalabels: {
                    anchor: 'start', align: 'start', color:'#fb8c00', font:{weight:'bold'}, formatter:v=>v.toFixed(2)
                }
            }
        ]
    },
    options: {
        responsive: true,
        indexAxis: 'x',
        plugins: {
            legend: { position: 'top' },
            datalabels: { display: true }
        },
        scales: {
            y: { min: 80, max: 105, ticks:{ callback:v=>v+'%' } }
        }
    },
    plugins: [ChartDataLabels]
});

// Eficiencia relativa (simula barras 3D con gradiente y borde)
const eficiencia = [0.99, 0.98, 1.01, 1.00, 1.00, 1.01, 0.98, 1.22, 1.00, 1.09, 1.02, 1.01, 0.99, 0.96, 1.00];
var ctxBar3DEfic = document.getElementById('bar3d_eficiencia').getContext('2d');
var barColorsEfic = grad3D(ctxBar3DEfic, "#bdbdbd", "#e3eaf6");

new Chart(ctxBar3DEfic, {
    type: 'bar',
    data: {
        labels: labelsUnidades,
        datasets: [
            {
                label: 'Eficiencia relativa',
                data: eficiencia,
                backgroundColor: barColorsEfic,
                borderColor: "#616161",
                borderWidth: 2,
                datalabels: {
                    anchor: 'end', align: 'end', color:'#1565c0', font:{weight:'bold'}, formatter:v=>v.toFixed(2)
                }
            }
        ]
    },
    options: {
        responsive: true,
        indexAxis: 'x',
        plugins: {
            legend: { position: 'top' },
            datalabels: { display: true }
        },
        scales: {
            y: { min: 0.85, max: 1.25, ticks:{ callback:v=>v.toFixed(2) } }
        }
    },
    plugins: [ChartDataLabels]
});
</script>