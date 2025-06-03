<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Resultados y Desviaciones - Carga Unidad</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/css/bootstrap.min.css">
    <style>
        textarea { width:100%; min-height:90px; }
        .kpi-row { margin-bottom:1em; }
        .main-title { font-size:1.2em; color:#1976d2; font-weight:bold;}
    </style>
</head>
<body>
<div class="container mt-3">
    <div class="main-title mb-2">Registro de Resultados y/o Desviaciones<br><small>Periodo: <?= esc($periodo) ?></small></div>
    <form method="post" action="/resultados-desviaciones/guardar">
        <input type="hidden" name="unidad_id" value="<?= esc($unidad_id) ?>">
        <input type="hidden" name="area_id" value="<?= esc($area_id) ?>">
        <input type="hidden" name="periodo" value="<?= esc($periodo) ?>">
        <div class="mb-2">
            <label>Resultados clave (narrativo):</label>
            <textarea name="resultados" required><?= esc($registro['resultados']??'') ?></textarea>
        </div>
        <div class="mb-2">
            <label>Desviaciones (narrativo):</label>
            <textarea name="desviaciones"><?= esc($registro['desviaciones']??'') ?></textarea>
        </div>
        <div class="row kpi-row">
            <div class="col-md-3">
                <label>% Avance Físico</label>
                <input type="number" name="avance_fisico" class="form-control" value="<?= esc($registro['avance_fisico']??'') ?>" min="0" max="100" step="0.01">
            </div>
            <div class="col-md-3">
                <label>% Ejecución Presupuestaria</label>
                <input type="number" name="ejec_presupuestaria" class="form-control" value="<?= esc($registro['ejec_presupuestaria']??'') ?>" min="0" max="100" step="0.01">
            </div>
            <div class="col-md-3">
                <label>% Eficiencia</label>
                <input type="number" name="eficiencia" class="form-control" value="<?= esc($registro['eficiencia']??'') ?>" min="0" max="100" step="0.01">
            </div>
            <div class="col-md-3">
                <label>Personas con discapacidad</label>
                <input type="number" name="personas_discapacidad" class="form-control" value="<?= esc($registro['personas_discapacidad']??0) ?>" min="0">
            </div>
        </div>
        <button class="btn btn-success" type="submit">Guardar</button>
    </form>
</div>
</body>
</html>