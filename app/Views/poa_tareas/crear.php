<?php
$title = "Nueva Tarea POA";
include(APPPATH.'Views/layouts/header.php');
?>
    <h2>Nueva Tarea POA</h2>
    <form method="post" action="/poa-tareas/crear">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" required><br>
        <label>Descripción:</label><br>
        <textarea name="descripcion"></textarea><br>
        <label>Estado:</label><br>
        <select name="estado">
            <option value="En Proceso">En Proceso</option>
            <option value="Completada">Completada</option>
            <option value="Pendiente">Pendiente</option>
        </select><br>
        <button type="submit">Guardar</button>
    </form>
    <a href="/poa-tareas">Volver</a>
<?php include(APPPATH.'Views/layouts/footer.php'); ?>