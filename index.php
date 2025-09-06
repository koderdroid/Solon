<?php
// Ejemplo de valores dinámicos. Puedes reemplazar por tus propias consultas PHP.
$stats = [
  ['label' => 'Leads', 'value' => '65K', 'delta' => '+4.2%', 'class' => 'ok'],
  ['label' => 'Nuevos Leads', 'value' => '12K', 'delta' => '+1.8%', 'class' => 'ok'],
  ['label' => 'Usuarios Activos', 'value' => '40', 'delta' => '=', 'class' => 'warn'],
  ['label' => 'Ingresos Totales', 'value' => '$890', 'delta' => '-0.6%', 'class' => 'err'],
];
$website = [
  ['title'=>'URL', 'meta'=>'www.example.com'],
  ['title'=>'Email', 'meta'=>'example@website.com'],
  ['title'=>'Teléfono', 'meta'=>'+00 1234 5678 90'],
];
$team = [
  ['title'=>'Ronald Green', 'meta'=>'ron@yourdomain.com'],
  ['title'=>'Nancy Farmer', 'meta'=>'nancy@yourdomain.com'],
  ['title'=>'Meta Discord', 'meta'=>'+00 1234 5678 90'],
  ['title'=>'Starbucks coffee', 'meta'=>'+00 1234 5678 90'],
];
$activity = [
  ['icon'=>'⚠️','title'=>'Task overdue', 'meta'=>'2 mins ago'],
  ['icon'=>'🆕','title'=>'Create new ticket', 'meta'=>'5 mins ago'],
  ['icon'=>'♻️','title'=>'Update report', 'meta'=>'1 day ago'],
];
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Metrica — Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  :root{
    --bg-page:#0f172a; --bg-surface:#111827; --bg-surface-alt:#0b1220;
    --border:#1f2937; --text:#e5e7eb; --text-2:#9ca3af; --text-3:#6b7280;
    --pri:#6366f1; --ok:#22c55e; --warn:#f59e0b; --err:#ef4444;
    --c1:#6366f1; --c2:#06b6d4; --c3:#f59e0b; --c4:#22c55e;
    --grid:rgba(148,163,184,0.18); --axis:rgba(148,163,184,0.6);
    --r-sm:8px; --r-md:12px; --r-lg:16px;
    --s-xxs:4px; --s-xs:8px; --s-sm:12px; --s-md:16px; --s-lg:24px; --s-xl:32px;
    --sidebar:260px; --topbar:56px; --container:1280px;
  }
  *{box-sizing:border-box}
  body{margin:0;background:var(--bg-page);color:var(--text);font-family:Inter,system-ui,sans-serif;line-height:1.5}
  .layout{display:grid;grid-template-columns: var(--sidebar) 1fr; min-height:100vh}
  aside{background:var(--bg-surface-alt);border-right:1px solid var(--border);padding:var(--s-lg) var(--s-md)}
  .logo{font-weight:700;letter-spacing:.4px;margin-bottom:var(--s-lg)}
  .nav a{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:8px;color:var(--text-2);text-decoration:none}
  .nav a:hover{background:#0e1629;color:var(--text)}
  main{display:flex;flex-direction:column}
  .topbar{height:var(--topbar);display:flex;align-items:center;gap:12px;padding:0 var(--s-lg);border-bottom:1px solid var(--border);background:var(--bg-surface)}
  .search{flex:1;display:flex;align-items:center;background:#0b1222;border:1px solid var(--border);border-radius:10px;padding:8px 12px;color:var(--text-2)}
  .container{max-width:var(--container);width:100%;margin:0 auto;padding:var(--s-lg)}
  .grid{display:grid;gap:var(--s-lg)}
  .grid.cols-4{grid-template-columns:repeat(4,1fr)}
  .grid.cols-3{grid-template-columns:repeat(3,1fr)}
  .grid.cols-2{grid-template-columns:repeat(2,1fr)}
  .card{background:var(--bg-surface);border:1px solid var(--border);border-radius:var(--r-md);padding:var(--s-lg);box-shadow:0 6px 18px rgba(0,0,0,.32)}
  .card h3{margin:0 0 var(--s-sm);font-size:14px;color:var(--text-2);font-weight:600}
  .stat{display:flex;align-items:center;justify-content:space-between}
  .stat .value{font-size:28px;font-weight:700}
  .delta{font-size:12px;border-radius:999px;padding:2px 8px;border:1px solid var(--border);color:var(--text-2)}
  .delta.ok{color:#10b981;background:rgba(16,185,129,.08);border-color:rgba(16,185,129,.3)}
  .delta.warn{color:#f59e0b;background:rgba(245,158,11,.08);border-color:rgba(245,158,11,.3)}
  .delta.err{color:#ef4444;background:rgba(239,68,68,.08);border-color:rgba(239,68,68,.3)}
  .chart{height:280px}
  .row{display:grid;grid-template-columns:2fr 1fr;gap:var(--s-lg)}
  .list{display:flex;flex-direction:column;gap:12px}
  .item{display:flex;justify-content:space-between;gap:12px;padding:10px;border:1px solid var(--border);border-radius:10px;background:#0b1222}
  .meta{color:var(--text-3);font-size:12px}
  .kpi{display:flex;gap:16px;flex-wrap:wrap}
  .pill{font-size:12px;border:1px solid var(--border);border-radius:999px;padding:4px 10px;color:var(--text-2)}
  @media (max-width: 1200px){ .grid.cols-4{grid-template-columns:repeat(2,1fr)} .row{grid-template-columns:1fr} }
  @media (max-width: 720px){ .layout{grid-template-columns: 1fr} aside{position:fixed;inset:0 40% 0 0;transform:translateX(-100%)} .topbar{position:sticky;top:0;z-index:10} .grid.cols-3,.grid.cols-2,.grid.cols-4{grid-template-columns:1fr} }
</style>
</head>
<body>
<div class="layout">
  <aside aria-label="Barra lateral">
    <div class="logo">Metrica</div>
    <nav class="nav" role="navigation">
      <a href="#"><span>🏠</span><span>Dashboard</span></a>
      <a href="#"><span>👥</span><span>Usuarios</span></a>
      <a href="#"><span>📈</span><span>Métricas</span></a>
      <a href="#"><span>⚙️</span><span>Ajustes</span></a>
    </nav>
  </aside>
  <main>
    <div class="topbar">
      <div class="search" role="search"><span>🔎</span><span style="margin-left:8px">Buscar...</span></div>
      <div class="pill">EN</div>
      <div class="pill">🔔</div>
      <div class="pill">👤</div>
    </div>

    <div class="container">
      <!-- Métricas superiores -->
      <div class="grid cols-4">
        <?php foreach($stats as $stat): ?>
          <div class="card">
            <h3><?= htmlspecialchars($stat['label']) ?></h3>
            <div class="stat">
              <div class="value"><?= htmlspecialchars($stat['value']) ?></div>
              <div class="delta <?= $stat['class'] ?>"><?= htmlspecialchars($stat['delta']) ?></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Gráfico de leads + Donut y KPIs -->
      <div class="row">
        <div class="card">
          <h3>Leads por proveedor</h3>
          <canvas id="leadsChart" class="chart" role="img" aria-label="Tendencia de leads multiserie"></canvas>
        </div>
        <div class="card">
          <h3>Nuevos Leads — Objetivo</h3>
          <div style="display:flex;align-items:center;gap:16px">
            <svg width="120" height="120" viewBox="0 0 120 120" role="img" aria-label="Progreso 70%">
              <circle cx="60" cy="60" r="48" fill="none" stroke="#1f2937" stroke-width="12" />
              <circle cx="60" cy="60" r="48" fill="none" stroke="var(--warn)" stroke-width="12"
                stroke-linecap="round" stroke-dasharray="301.59"
                stroke-dashoffset="90.48" transform="rotate(-90 60 60)" />
              <text x="60" y="66" text-anchor="middle" fill="var(--text)" font-size="18" font-weight="700">70%</text>
            </svg>
            <div>
              <div style="font-size:28px;font-weight:700">402</div>
              <div class="meta">Leads</div>
              <div class="kpi" style="margin-top:10px">
                <span class="pill">Target</span><span class="pill">Q3</span>
              </div>
            </div>
          </div>
          <div style="margin-top:16px" class="list">
            <div class="item"><span>Revenue mensual</span><span>$955</span></div>
            <div class="item"><span>Revenue total</span><span>$3,520.00</span></div>
            <div class="item"><span>Followers</span><span>184K</span></div>
            <div class="item"><span>Following</span><span>101K</span></div>
          </div>
        </div>
      </div>

      <!-- Website / Team / Activity -->
      <div class="grid cols-3" style="margin-top:24px">
        <div class="card">
          <h3>Website</h3>
          <div class="list">
            <?php foreach($website as $item): ?>
              <div class="item"><span><?= htmlspecialchars($item['title']) ?></span><span class="meta"><?= htmlspecialchars($item['meta']) ?></span></div>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="card">
          <h3>Team Members</h3>
          <div class="list">
            <?php foreach($team as $item): ?>
              <div class="item"><span><?= htmlspecialchars($item['title']) ?></span><span class="meta"><?= htmlspecialchars($item['meta']) ?></span></div>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="card">
          <h3>Actividad</h3>
          <div class="list">
            <?php foreach($activity as $item): ?>
              <div class="item"><span><?= $item['icon'].' '.htmlspecialchars($item['title']) ?></span><span class="meta"><?= htmlspecialchars($item['meta']) ?></span></div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>

<!-- Gráfico de líneas con Canvas 2D (sin dependencias JS externas) -->
<script>
  (function(){
    const canvas = document.getElementById('leadsChart');
    const dpr = window.devicePixelRatio || 1;
    const w = canvas.clientWidth, h = canvas.clientHeight;
    canvas.width = w * dpr; canvas.height = h * dpr;
    const ctx = canvas.getContext('2d'); ctx.scale(dpr, dpr);

    // Datos de ejemplo multiserie
    const labels = Array.from({length: 12}, (_,i)=> i+1); // meses 1..12
    const series = [
      { name:'Vendor A', color:getVar('--c1'), data:[30,35,28,40,44,38,50,55,52,60,58,65] },
      { name:'Vendor B', color:getVar('--c2'), data:[22,25,20,28,26,30,35,34,36,38,40,42] },
      { name:'Vendor C', color:getVar('--c3'), data:[12,14,16,15,18,22,24,25,26,28,30,33] }
    ];

    // Márgenes del área de dibujo
    const m = {t:24,r:20,b:28,l:36};
    const plot = { x:m.l, y:m.t, w:w - m.l - m.r, h:h - m.t - m.b };

    // Escalas
    const yMax = Math.ceil(Math.max(...series.flatMap(s=>s.data))/10)*10;
    const yMin = 0;
    const xTo = i => plot.x + (i/(labels.length-1))*plot.w;
    const yTo = v => plot.y + plot.h - ((v - yMin)/(yMax - yMin))*plot.h;

    // Grid horizontal
    ctx.strokeStyle = getVar('--grid'); ctx.lineWidth = 1;
    const ticks = 5;
    for(let i=0;i<=ticks;i++){
      const y = plot.y + (i/ticks)*plot.h;
      ctx.beginPath(); ctx.moveTo(plot.x, y); ctx.lineTo(plot.x+plot.w, y); ctx.stroke();
    }

    // Ejes
    ctx.strokeStyle = getVar('--axis');
    ctx.beginPath(); ctx.moveTo(plot.x, plot.y); ctx.lineTo(plot.x, plot.y+plot.h); ctx.stroke();
    ctx.beginPath(); ctx.moveTo(plot.x, plot.y+plot.h); ctx.lineTo(plot.x+plot.w, plot.y+plot.h); ctx.stroke();

    // Etiquetas X (pocas para claridad)
    ctx.fillStyle = getVar('--axis'); ctx.font = '12px Inter';
    labels.forEach((lb,i)=>{ if(i%2===0){ ctx.fillText(lb, xTo(i)-3, plot.y+plot.h+16); } });

    // Series
    series.forEach(s=>{
      ctx.lineWidth = 2; ctx.strokeStyle = s.color; ctx.beginPath();
      s.data.forEach((v,i)=>{ const x=xTo(i), y=yTo(v); if(i===0) ctx.moveTo(x,y); else ctx.lineTo(x,y); });
      ctx.stroke();
      // Puntos
      ctx.fillStyle = s.color;
      s.data.forEach((v,i)=>{ const x=xTo(i), y=yTo(v); ctx.beginPath(); ctx.arc(x,y,2.5,0,Math.PI*2); ctx.fill(); });
    });

    function getVar(name){ return getComputedStyle(document.documentElement).getPropertyValue(name).trim(); }
  })();
</script>
</body>
</html>