<?php
$title = "Editar Avance Narrativo";
include(APPPATH.'Views/layouts/header.php');
?>
    <h2>Editar Avance Narrativo</h2>
    <form method="post" action="/avance-tarea/editar/<?= $avance['id'] ?>">
        <label>Período:</label>
        <input type="text" name="periodo" value="<?= esc($avance['periodo']) ?>" required>
        <label>Indicador relacionado:</label>
        <input type="text" name="indicador_id" value="<?= esc($avance['indicador_id']) ?>">
        <label>Avance (texto narrativo):</label>
        <textarea name="avance_texto" required><?= esc($avance['avance_texto']) ?></textarea>
        <label>Usuario:</label>
        <input type="text" name="usuario" value="<?= esc($avance['usuario']) ?>" required>
        <button type="submit">Guardar cambios</button>
    </form>
    <a href="/poa-tareas/ver/<?= $avance['tarea_id'] ?>">Volver</a>
<?php include(APPPATH.'Views/layouts/footer.php'); ?>