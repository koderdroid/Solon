<?php
$title = "Tareas POA";
include(APPPATH.'Views/layouts/header.php');
?>
    <h2>Tareas del POA</h2>
    <form method="get" action="/poa-tareas">
        <label>Filtrar por estado:</label>
        <select name="estado">
            <option value="">-- Todos --</option>
            <option value="En Proceso"<?= ($filtros['estado']??'')=='En Proceso'?' selected':'' ?>>En Proceso</option>
            <option value="Completada"<?= ($filtros['estado']??'')=='Completada'?' selected':'' ?>>Completada</option>
            <option value="Pendiente"<?= ($filtros['estado']??'')=='Pendiente'?' selected':'' ?>>Pendiente</option>
        </select>
        <label>Indicador:</label>
        <select name="indicador_id">
            <option value="">-- Todos --</option>
            <?php foreach($indicadores as $ind): ?>
                <option value="<?= $ind['id'] ?>"<?= ($filtros['indicador_id']??'')==$ind['id']?' selected':'' ?>>
                    <?= esc($ind['codigo']) ?> - <?= esc($ind['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <label>Período:</label>
        <input type="text" name="periodo" value="<?= esc($filtros['periodo']??'') ?>" placeholder="Ej: 2025-T1">
        <button type="submit">Filtrar</button>
        <a href="/poa-tareas" class="btn">Limpiar</a>
    </form>
    <a href="/poa-tareas/crear" class="btn">Nueva Tarea</a>
    <table class="display">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Último Avance</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($tareas as $t): ?>
            <tr>
                <td><a href="/poa-tareas/ver/<?= $t['id'] ?>"><?= esc($t['nombre']) ?></a></td>
                <td><?= esc($t['estado']) ?></td>
                <td>
                    <?php
                    $ultimo = null;
                    if (!empty($avances_filtrados)) {
                        foreach($avances_filtrados as $av) {
                            if ($av['tarea_id'] == $t['id']) $ultimo = $av;
                        }
                    }
                    if ($ultimo) {
                        echo esc($ultimo['periodo']).' - '.substr(strip_tags($ultimo['avance_texto']),0,40).'...';
                    } else {
                        echo "-";
                    }
                    ?>
                </td>
                <td>
                    <a href="/poa-tareas/ver/<?= $t['id'] ?>">Ver</a>
                    <a href="/poa-tareas/editar/<?= $t['id'] ?>">Editar</a>
                    <a href="/poa-tareas/eliminar/<?= $t['id'] ?>" onclick="return confirm('¿Eliminar?')">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php include(APPPATH.'Views/layouts/footer.php'); ?>