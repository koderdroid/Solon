<?php
// Plantilla simplificada para exportar Formulario 2 a PDF (usa mPDF/dompdf, etc)
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Formulario 2 - Ejecución Operativa (PDF)</title>
    <style>
        body { font-family: Arial, sans-serif; font-size:11px;}
        table { border-collapse: collapse; width:100%; }
        th, td { border:1px solid #bbb; padding:4px 6px; font-size:11px; }
        th { background:#d5f0ff; }
        .area-total { background:#f3f3f3; font-weight:bold; }
    </style>
</head>
<body>
<h2>Formulario 2 - Ejecución Operativa</h2>
<p>Área: <?= esc($area['nombre']) ?> | Periodo: <?= esc($periodo) ?></p>
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
                <td><?= esc($avances[$t['id']]) ?></td>
                <td><?= number_format($presupuestos[$t['id']]['presupuesto_vigente'],2) ?></td>
                <td><?= number_format($presupuestos[$t['id']]['presupuesto_ejecutado'],2) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>
    <tr class="area-total">
        <td colspan="6">PRESUPUESTO ÁREA <?= esc($area['nombre']) ?> - <?= esc($periodo) ?></td>
        <td><?= number_format($area_pres['presupuesto_vigente']??0,2) ?></td>
        <td><?= number_format($area_pres['presupuesto_ejecutado']??0,2) ?></td>
    </tr>
    </tbody>
</table>
</body>
</html>