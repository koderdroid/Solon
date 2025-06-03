<?php
/**
 * Plantilla para FORMULARIO 1 (ajustada para lógica de 2025 "Prog." y "Ejec.", y 2024 unificada)
 * 
 * Variables de entrada:
 * - $cabecera: array (igual que antes)
 * - $filas: resultado de Poa_model::obtener_formulario1()
 * - $modo_edicion: bool
 * - $periodos_2025: array de meses ⇒ ej: ['Prog.', 'Ene', 'Feb', ..., 'Dic']
 * - $avance_2025: array por fila y periodo actual (avance_2025[$fila['id']][$periodo])
 * - $periodo_edicion: string ('Prog.', 'Ene', ..., 'Dic') (el periodo editable actualmente, sólo uno a la vez)
 * - $usuario_autorizado: bool
 */

function celda($valor, $editable = false, $name = '', $id = '', $extra = '') {
    if ($editable) {
        return '<textarea class="text-area-edit" name="'.$name.'" id="'.$id.'" '.$extra.'>'.htmlspecialchars($valor).'</textarea>';
    } else {
        return '<div class="text-area-read">'.htmlspecialchars($valor).'</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>PLAN OPERATIVO ANUAL - FORMULARIO 1</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 25px; background: #fff; }
        .header-row { display: flex; align-items: center; margin-bottom: 10px; }
        .logo { height: 80px; margin-right: 10px; }
        .org-title { flex: 1; text-align: center; }
        .right-logo { height: 80px; margin-left: 10px; }
        h2 { font-size: 1.2em; margin: 0; }
        .block { margin-bottom: 8px; }
        .info-table { width: 100%; border: none; margin-bottom: 10px; }
        .info-table td { padding: 2px 8px; }
        .cuadro { width: 100%; border-collapse: collapse; }
        .cuadro th, .cuadro td { border: 1px solid #222; padding: 2px 4px; font-size: 11px; }
        .cuadro th { background: #e0e0e0; text-align: center; }
        .cuadro td { vertical-align: top; }
        .readonly { background: #f9f9f9; color: #555; }
        .editable { background: #eef; }
        .section-label { font-weight: bold; font-size: 1.1em; }
        .legend { font-size: 10px; color: #444; margin-top: 6px; }
        .text-area-edit { width: 100%; min-height: 30px; border: 1px solid #ccc; background: #eef; }
        .text-area-read { width: 100%; min-height: 30px; border: 1px solid #eee; background: #fafafa; }
    </style>
</head>
<body>
    <div class="header-row">
        <img src="/assets/img/bolivia_izq.png" class="logo" alt="Escudo Bolivia">
        <div class="org-title">
            <img src="/assets/img/senape_logo.png" style="height: 30px;" alt="SENAPE"><br>
            <span>MINISTERIO DE ECONOMÍA Y FINANZAS PÚBLICAS<br>VICEMINISTERIO DE TESORO Y CRÉDITO PÚBLICO</span>
            <h2>PLAN OPERATIVO ANUAL<br>ACCIONES A CORTO PLAZO<br><u>FORMULARIO Nro. 1</u></h2>
        </div>
        <img src="/assets/img/bolivia_der.png" class="right-logo" alt="Escudo Estado">
    </div>
    <table class="info-table">
        <tr>
            <td class="section-label">ÁREA ORGANIZACIONAL:</td>
            <td><?= htmlspecialchars($cabecera['area_org'] ?? '') ?></td>
            <td class="section-label">GESTIÓN DEL POA:</td>
            <td><?= htmlspecialchars($cabecera['gestion_poa'] ?? '') ?></td>
            <td class="section-label">SIGLA:</td>
            <td><?= htmlspecialchars($cabecera['sigla'] ?? '') ?></td>
        </tr>
    </table>
    <div class="block">
        <div class="section-label">Visión:</div>
        <div class="readonly"><?= htmlspecialchars($cabecera['vision'] ?? '') ?></div>
    </div>
    <div class="block">
        <div class="section-label">Misión:</div>
        <div class="readonly"><?= htmlspecialchars($cabecera['mision'] ?? '') ?></div>
    </div>
    <div class="block">
        <div class="section-label">Eje Estratégico:</div>
        <div class="readonly"><?= htmlspecialchars($cabecera['eje'] ?? '') ?></div>
    </div>
    <div class="block">
        <div class="section-label">Meta:</div>
        <div class="readonly"><?= htmlspecialchars($cabecera['meta'] ?? '') ?></div>
    </div>
    <div class="block">
        <div class="section-label">Resultado:</div>
        <div class="readonly"><?= htmlspecialchars($cabecera['resultado'] ?? '') ?></div>
    </div>
    <div class="block">
        <div class="section-label">Acción:</div>
        <div class="readonly"><?= htmlspecialchars($cabecera['accion'] ?? '') ?></div>
    </div>
    <div class="block">
        <div class="section-label">Acción Estratégica Ministerial:</div>
        <div class="readonly"><?= htmlspecialchars($cabecera['accion_estrategica'] ?? '') ?></div>
    </div>
    <div class="block">
        <div class="section-label">Objetivo Estratégico SENAPE 2021-2025:</div>
        <div class="readonly"><?= htmlspecialchars($cabecera['objetivo_estrategico'] ?? '') ?></div>
    </div>
    <form method="post" action="" id="form-formulario1">
    <table class="cuadro" id="tabla_formulario1">
        <thead>
            <tr>
                <th rowspan="2">Cód. PEI</th>
                <th rowspan="2">Denominación</th>
                <th rowspan="2">Cód. POA</th>
                <th rowspan="2">Objetivo Estratégico</th>
                <th rowspan="2" style="background: #d3e6f5;">Acción de Mediano Plazo</th>
                <th rowspan="2">Acción de Corto Plazo</th>
                <th rowspan="2">Producto</th>
                <th rowspan="2">Descripción del Indicador</th>
                <th rowspan="2">Unidad de medida</th>
                <th rowspan="2">Fórmula</th>
                <th rowspan="2">Meta 2021-2025</th>
                <th rowspan="2">Ejec. 2024 (IV Trim.)</th>
                <?php if (!empty($periodos_2025)): ?>
                    <?php foreach ($periodos_2025 as $p): ?>
                        <th><?= htmlspecialchars($p === 'Prog.' ? '2025<br>Prog.' : '2025<br>Ejec. '.$p) ?></th>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($filas as $i => $fila): ?>
            <tr>
                <td class="readonly"><?= htmlspecialchars($fila['cod_pei']) ?></td>
                <td class="readonly"><?= htmlspecialchars($fila['denominacion']) ?></td>
                <td class="readonly"><?= htmlspecialchars($fila['cod_poa']) ?></td>
                <td class="readonly"><?= htmlspecialchars($fila['objetivo_estrategico']) ?></td>
                <td class="readonly"><?= htmlspecialchars($fila['accion_mediano_plazo']) ?></td>
                <td class="<?= $modo_edicion ? 'editable' : 'readonly' ?>">
                    <?= celda($fila['accion_corto_plazo'], $modo_edicion, "accion_corto_plazo[{$fila['id']}]", "accion_corto_plazo_{$fila['id']}") ?>
                </td>
                <td class="<?= $modo_edicion ? 'editable' : 'readonly' ?>">
                    <?= celda($fila['producto'], $modo_edicion, "producto[{$fila['id']}]", "producto_{$fila['id']}") ?>
                </td>
                <td class="readonly"><?= htmlspecialchars($fila['descripcion_indicador']) ?></td>
                <td class="readonly"><?= htmlspecialchars($fila['unidad_medida']) ?></td>
                <td class="readonly"><?= htmlspecialchars($fila['formula']) ?></td>
                <td class="readonly"><?= htmlspecialchars($fila['meta_2021_2025']) ?></td>
                <td class="readonly"><?= htmlspecialchars($fila['ejec_2024']) ?></td>
                <?php
                if (!empty($periodos_2025)):
                    foreach ($periodos_2025 as $p):
                        $v = $avance_2025[$fila['id']][$p] ?? '';
                        $esEditable = $usuario_autorizado && $modo_edicion && $p === $periodo_edicion;
                        echo '<td class="'.($esEditable ? 'editable' : 'readonly').'">';
                        if ($esEditable) {
                            echo '<input type="number" step="0.01" class="text-area-edit" name="avance_2025['.$fila['id'].']['.$p.']" value="'.htmlspecialchars($v).'">';
                        } else {
                            echo '<div class="text-area-read">'.htmlspecialchars($v).'</div>';
                        }
                        echo '</td>';
                    endforeach;
                endif;
                ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php if ($usuario_autorizado && $modo_edicion): ?>
        <button type="submit">Guardar cambios</button>
    <?php endif; ?>
    </form>
    <div class="legend">
        *Solo "Acción de Corto Plazo", "Producto", y el periodo 2025 vigente son editables (según usuario/etapa). El resto es inamovible por ciclo PEI.<br>
        *El historial anterior (2024 y previos) es siempre visible pero no editable.<br>
        *El texto de la gestión vigente se mantiene en nuevos periodos de Formulación y sólo cambia si se edita.
    </div>
</body>
</html>