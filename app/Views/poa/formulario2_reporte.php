<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>POA - FORMULARIO 2 · Reporte Operativo</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 24px; background: #fff; }
        h2 { font-size: 1.25em; margin: 8px 0 10px 0; }
        .header-row { display: flex; align-items: center; margin-bottom: 12px; }
        .logo { height: 70px; margin-right: 10px; }
        .org-title { flex: 1; text-align: center; }
        .right-logo { height: 70px; margin-left: 10px; }
        .info-table { width: 100%; border: none; margin-bottom: 10px; }
        .info-table td { padding: 2px 10px; font-size: 13px; }
        table.cuadro { width: 100%; border-collapse: collapse; margin-top: 10px;}
        table.cuadro th, table.cuadro td { border: 1px solid #222; padding: 3px 5px; font-size: 11px; }
        table.cuadro th { background: #c7e4f0; text-align: center; }
        table.cuadro tr.operacion { background: #e8f2fa; font-weight: bold; }
        .readonly { background: #f9f9f9; color: #222; }
        .section-label { font-weight: bold; font-size: 1.08em; }
        .text-area-read { width: 100%; min-height: 30px; border: 1px solid #eee; background: #fafafa; }
        .center { text-align: center; }
        .small { font-size: 10px; color: #666; }
        .w-80 { width:80px; }
        .w-60 { width:60px; }
    </style>
</head>
<body>
    <!-- Encabezados -->
    <div class="header-row">
        <img src="/assets/img/bolivia_izq.png" class="logo" alt="Escudo Bolivia">
        <div class="org-title">
            <img src="/assets/img/senape_logo.png" style="height: 30px;" alt="SENAPE"><br>
            <span>MINISTERIO DE ECONOMÍA Y FINANZAS PÚBLICAS<br>VICEMINISTERIO DE TESORO Y CRÉDITO PÚBLICO</span>
            <h2>REPORTE OPERATIVO DEL POA<br><u>FORMULARIO Nro. 2</u></h2>
        </div>
        <img src="/assets/img/bolivia_der.png" class="right-logo" alt="Escudo Estado">
    </div>
    <!-- Información resumen -->
    <table class="info-table">
        <tr>
            <td class="section-label">Año:</td>
            <td><?= htmlspecialchars($cabecera['anio'] ?? '') ?></td>
            <td class="section-label">Unidad Responsable:</td>
            <td><?= htmlspecialchars($cabecera['unidad_responsable'] ?? '') ?></td>
            <td class="section-label">Fecha de generación:</td>
            <td><?= htmlspecialchars($cabecera['fecha_generacion'] ?? date('Y-m-d')) ?></td>
        </tr>
    </table>
    <div class="section-label">Dirección / Unidad: <?= htmlspecialchars($cabecera['direccion_nombre'] ?? '') ?></div>
    <!-- Tabla principal -->
    <table class="cuadro" id="tabla_formulario2">
        <thead>
        <tr>
            <th rowspan="2">CÓDIGO</th>
            <th rowspan="2">OPERACIÓN<br>(OBJETIVO ESPECÍFICO)</th>
            <th rowspan="2">RESULTADOS<br>ESPERADOS</th>
            <th rowspan="2">Pond.<br>Op.</th>
            <th rowspan="2">INDICADOR</th>
            <th rowspan="2">TAREA<br>(OPERACIÓN)</th>
            <th rowspan="2">PONO</th>
            <th rowspan="2">MEDIO DE VERIFICACIÓN</th>
            <th rowspan="2">METAS</th>
            <th rowspan="2">RESP. ORG</th>
            <th rowspan="2">INDICADOR2</th>
            <th colspan="2">PERIODO</th>
            <th rowspan="2">AVANCE (%)</th>
            <th rowspan="2">OBSERVACIONES</th>
            <th rowspan="2">DOCUMENTO</th>
            <th rowspan="2">USUARIO</th>
            <th rowspan="2">FECHA</th>
        </tr>
        <tr>
            <th>Ini.</th>
            <th>Fin.</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $op_actual = '';
        foreach ($filas as $fila):
            // Imprime cabecera de operación solo si cambia
            if ($op_actual !== $fila['codigo_operacion']) {
                $op_actual = $fila['codigo_operacion'];
                ?>
                <tr class="operacion">
                    <td colspan="18"><?= htmlspecialchars($fila['codigo_operacion'].' · '.$fila['nombre_operacion']) ?></td>
                </tr>
            <?php }
            ?>
            <tr>
                <td class="readonly"><?= htmlspecialchars($fila['codigo_tarea']) ?></td>
                <td class="readonly"><?= htmlspecialchars($fila['nombre_operacion']) ?></td>
                <td class="readonly"><?= htmlspecialchars($fila['descripcion_tarea']) ?></td>
                <td class="center"><?= htmlspecialchars($fila['pond_tarea']) ?></td>
                <td class="readonly"><?= htmlspecialchars($fila['indicador']) ?></td>
                <td class="readonly"><?= htmlspecialchars($fila['descripcion_tarea']) ?></td>
                <td class="center"><?= htmlspecialchars($fila['pond_tarea']) ?></td>
                <td class="readonly"><?= htmlspecialchars($fila['medios_verificacion']) ?></td>
                <td class="readonly"><?= htmlspecialchars($fila['meta']) ?></td>
                <td class="readonly"><?= htmlspecialchars($fila['responsable']) ?></td>
                <td class="readonly"><?= htmlspecialchars($fila['indicador2'] ?? '') ?></td>
                <td class="center w-60"><?= htmlspecialchars($fila['periodo_ini'] ?? '') ?></td>
                <td class="center w-60"><?= htmlspecialchars($fila['periodo_fin'] ?? '') ?></td>
                <td class="center w-60"><?= htmlspecialchars($fila['avance_porcentaje']) ?>%</td>
                <td><?= htmlspecialchars($fila['observaciones']) ?></td>
                <td>
                    <?php if (!empty($fila['documento_adjunto'])): ?>
                        <a href="<?= htmlspecialchars($fila['documento_adjunto']) ?>" target="_blank">Ver</a>
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($fila['usuario_registro']) ?></td>
                <td class="center"><?= htmlspecialchars($fila['fecha_registro']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="small">
        <br>*Este reporte refleja el avance operativo de las tareas del POA, agrupadas por operación/objetivo específico y dirección/unidad funcional.
        <br>*"PONO" = Ponderación de la tarea/operación; "Meta" = Descripción cuantitativa/cualitativa esperada; "Documento" = Enlace a medio de verificación.
    </div>
</body>
</html>