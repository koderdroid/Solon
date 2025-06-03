<?php
$title = "Editar Tarea POA";
include(APPPATH.'Views/layouts/header.php');
?>
    <h2>Editar Tarea POA</h2>
    <form method="post" action="/poa-tareas/editar/<?= $tarea['id'] ?>">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" value="<?= esc($tarea['nombre']) ?>" required><br>
        <label>Descripción:</label><br>
        <textarea name="descripcion"><?= esc($tarea['descripcion']) ?></textarea><br>
        <label>Estado:</label><br>
        <select name="estado">
            <option value="En Proceso"<?= $tarea['estado']=='En Proceso'?' selected':'' ?>>En Proceso</option>
            <option value="Completada"<?= $tarea['estado']=='Completada'?' selected':'' ?>>Completada</option>
            <option value="Pendiente"<?= $tarea['estado']=='Pendiente'?' selected':'' ?>>Pendiente</option>
        </select><br>
        <button type="submit">Actualizar</button>
    </form>
    <a href="/poa-tareas/ver/<?= $tarea['id'] ?>">Volver</a>
<?php include(APPPATH.'Views/layouts/footer.php'); ?>