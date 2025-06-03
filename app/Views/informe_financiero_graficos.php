<!-- ...todo el código previo... -->

<!-- Drill-down interactivo -->
<div class="chart-container mb-3">
    <div class="cuadro-title mb-2">Análisis Interactivo por Nivel y Actividad</div>
    <form id="drilldown-filtros" class="row g-2 mb-2">
        <div class="col-md-2">
            <select id="filtro-gestion" class="form-select">
                <option value="">Gestión</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
            </select>
        </div>
        <div class="col-md-2">
            <select id="filtro-nivel" class="form-select">
                <option value="">Nivel</option>
                <option value="estrategico">Estratégico</option>
                <option value="organizacional">Organizacional</option>
            </select>
        </div>
        <div class="col-md-2">
            <select id="filtro-area" class="form-select">
                <option value="">Área</option>
                <option value="DRP">DRP</option>
                <option value="DAF">DAF</option>
                <option value="DBRAE">DBRAE</option>
                <!-- Completar áreas -->
            </select>
        </div>
        <div class="col-md-3">
            <select id="filtro-actividad" class="form-select">
                <option value="">Actividad</option>
                <option value="06">06 Gestión y Fortalecimiento SENAPE</option>
                <option value="07">07 Liquidación de Entes Gestores</option>
                <option value="10">10 Disposición de Bienes</option>
                <option value="93">93 Inserción laboral</option>
                <!-- Completar actividades -->
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary" type="button" onclick="aplicarDrilldown()">Filtrar/Desglosar</button>
        </div>
    </form>
    <div id="drilldown-tabla"></div>
    <canvas id="drilldown-grafico" height="110"></canvas>
</div>
<script>
// Simulación de datos jerárquicos, en real reemplazar por AJAX a backend
const datosDrilldown = [
    {gestion:'2024', nivel:'estrategico', area:'DRP', actividad:'06', monto:5000000, ejecutado:4500000, porcentaje:90},
    {gestion:'2024', nivel:'organizacional', area:'DAF', actividad:'07', monto:2000000, ejecutado:1950000, porcentaje:97.5},
    {gestion:'2024', nivel:'estrategico', area:'DBRAE', actividad:'10', monto:1000000, ejecutado:900000, porcentaje:90},
    {gestion:'2025', nivel:'estrategico', area:'DRP', actividad:'06', monto:5200000, ejecutado:5100000, porcentaje:98},
    {gestion:'2025', nivel:'organizacional', area:'DAF', actividad:'07', monto:2100000, ejecutado:2090000, porcentaje:99.5},
    // ...más datos reales...
];

function aplicarDrilldown() {
    const gestion = document.getElementById('filtro-gestion').value;
    const nivel = document.getElementById('filtro-nivel').value;
    const area = document.getElementById('filtro-area').value;
    const actividad = document.getElementById('filtro-actividad').value;

    // Filtrado
    let resultado = datosDrilldown.filter(r =>
        (!gestion || r.gestion == gestion) &&
        (!nivel || r.nivel == nivel) &&
        (!area || r.area == area) &&
        (!actividad || r.actividad == actividad)
    );

    // Mostrar tabla dinámica
    let tabla = `<table class="table table-bordered table-sm align-middle"><thead>
        <tr><th>Gestión</th><th>Nivel</th><th>Área</th><th>Actividad</th><th>Presupuesto</th><th>Ejecutado</th><th>% Ejecución</th></tr>
        </thead><tbody>`;
    resultado.forEach(r => {
        tabla += `<tr>
            <td>${r.gestion}</td>
            <td>${r.nivel}</td>
            <td>${r.area}</td>
            <td>${r.actividad}</td>
            <td>${r.monto.toLocaleString('es-BO')}</td>
            <td>${r.ejecutado.toLocaleString('es-BO')}</td>
            <td>${r.porcentaje}%</td>
        </tr>`;
    });
    if (!resultado.length) tabla += `<tr><td colspan="7" style="color:#b71c1c">Sin datos para los filtros seleccionados.</td></tr>`;
    tabla += `</tbody></table>`;
    document.getElementById('drilldown-tabla').innerHTML = tabla;

    // Gráfico dinámico
    const ctx = document.getElementById('drilldown-grafico').getContext('2d');
    if (window.drilldownChart) window.drilldownChart.destroy();
    window.drilldownChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: resultado.map(r=>`${r.actividad} (${r.area})`),
            datasets: [
                {label:'Presupuesto', data:resultado.map(r=>r.monto), backgroundColor:'#1976d2'},
                {label:'Ejecutado', data:resultado.map(r=>r.ejecutado), backgroundColor:'#43a047'},
                {label:'% Ejecución', data:resultado.map(r=>r.porcentaje), backgroundColor:'#fbc02d', type:'line', yAxisID:'y2', order:0}
            ]
        },
        options: {
            plugins: { legend:{position:'top'} },
            scales: {
                y: { beginAtZero:true, title:{display:true,text:'Bs'} },
                y2: { position:'right', beginAtZero:true, min:0, max:110, grid:{drawOnChartArea:false}, title:{display:true,text:'% Ejecución'}, ticks:{callback:v=>v+'%'} }
            }
        }
    });
}
</script>