<?php
// Vista tipo hoja de cálculo para edición/carga
?>
<!DOCTYPE html>
<html>
<head>
    <title>Formulario 2 - Ejecución Operativa</title>
    <style>
        table { border-collapse: collapse; width:100%; }
        th, td { border:1px solid #bbb; padding:4px 6px; font-size:12px; }
        th { background:#d5f0ff; }
        .area-total { background:#f3f3f3; font-weight:bold; }
        input[type='number'] { width:70px; }
    </style>
</head>
<body>
<h2>Formulario 2 - Ejecución Operativa<br>
Área: <?= esc($area['nombre']) ?> | Periodo: <?= esc($periodo) ?></h2>
<form method="post" action="/formulario2/guardar">
    <input type="hidden" name="area_id" value="<?= esc($area['id']) ?>">
    <input type="hidden" name="periodo" value="<?= esc($periodo) ?>">
    <table>
        <thead>
            <tr>
                <th>Cod.Op</th><th>Código</th>
                <th>Operación</th><th>Tarea</th>
                <th>Pond(%)</th>
                <th>Avance Físico (%)</th>
                <th>Ppto vigente</th>
                <th>Ppto ejecutado</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($operaciones as $op): ?>
            <tr class="area-total"><td><?= esc($op['cod_op']) ?></td><td></td>
                <td colspan="2"><?= esc($op['nombre']) ?></td>
                <td></td><td></td>
                <td></td><td></td>
            </tr>
            <?php foreach($tareas[$op['id']] as $t): ?>
                <tr>
                    <td></td>
                    <td><?= esc($t['codigo']) ?></td>
                    <td></td>
                    <td><?= esc($t['nombre']) ?></td>
                    <td><?= esc($t['ponderacion']) ?></td>
                    <td>
                        <input type="number" name="avance[<?= $t['id'] ?>]" value="<?= esc($avances[$t['id']]) ?>" min="0" max="100" step="0.01">
                    </td>
                    <td><?= number_format($presupuestos[$t['id']]['presupuesto_vigente'],2) ?></td>
                    <td><?= number_format($presupuestos[$t['id']]['presupuesto_ejecutado'],2) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
        <tr class="area-total">
            <td colspan="6">PRESUPUESTO ÁREA <?= esc($area['nombre']) ?> - <?= esc($periodo) ?></td>
            <td><?= number_format($area_pres['presupuesto_vigente']??0,2) ?></td>
            <td>
                <input type="number" name="presupuesto_ejecutado" value="<?= esc($area_pres['presupuesto_ejecutado']??0) ?>" min="0" step="0.01">
            </td>
        </tr>
        </tbody>
    </table>
    <button type="submit">Guardar avance y presupuesto</button>
</form>
</body>
</html>