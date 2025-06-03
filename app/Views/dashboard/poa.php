<?php
// ... resto del encabezado, scripts y cards ...
?>
<form method="get" id="filtros-form" style="margin-bottom: 1.5em;">
    <b>Área:</b>
    <select name="direccion_id" id="filtro_direccion">
        <option value="">Todas</option>
        <?php foreach($resumen['direcciones'] as $dir): ?>
            <option value="<?= esc($dir['id']) ?>"<?= $filtros['direccion_id']==$dir['id']?' selected':'' ?>>
                <?= esc($dir['nombre']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <b>Unidad:</b>
    <select name="unidad_id" id="filtro_unidad">
        <option value="">Todas</option>
        <?php foreach($unidades as $u): ?>
            <option value="<?= esc($u['id']) ?>"><?= esc($u['nombre']) ?></option>
        <?php endforeach; ?>
    </select>
    <b>Operación:</b>
    <select name="operacion_id" id="filtro_operacion">
        <option value="">Todas</option>
        <?php foreach($operaciones as $op): ?>
            <option value="<?= esc($op['id']) ?>"<?= $filtros['operacion_id']==$op['id']?' selected':'' ?>>
                <?= esc($op['codigo']) ?> - <?= esc($op['nombre']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <b>Estado:</b>
    <select name="cumplimiento">
        <option value="">Todos</option>
        <option value="1"<?= $filtros['cumplimiento']==='1'?' selected':'' ?>>Cumplidas</option>
        <option value="0"<?= $filtros['cumplimiento']==='0'?' selected':'' ?>>Pendientes</option>
    </select>
    <button type="submit">Filtrar</button>
</form>
<!-- ... resto de la tabla y scripts ... -->