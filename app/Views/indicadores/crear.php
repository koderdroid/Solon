<?php
$title = "Nuevo Indicador";
include(APPPATH.'Views/layouts/header.php');
?>
    <h2>Nuevo Indicador</h2>
    <form method="post" action="/indicadores/crear">
        <label>Código:</label><br>
        <input type="text" name="codigo" required><br>
        <label>Nombre:</label><br>
        <input type="text" name="nombre" required><br>
        <label>Área:</label><br>
        <input type="text" name="area" required><br>
        <label>Tipo:</label><br>
        <select name="tipo">
            <option value="estrategico">Estratégico</option>
            <option value="complementario">Complementario</option>
            <option value="proceso">Proceso</option>
            <option value="evaluacion">Evaluación</option>
            <option value="area">Área específica</option>
        </select><br>
        <label>Fórmula:</label><br>
        <textarea name="formula"></textarea><br>
        <label>Meta:</label><br>
        <input type="text" name="meta"><br>
        <label>Descripción:</label><br>
        <textarea name="descripcion"></textarea><br>
        <button type="submit">Guardar</button>
    </form>
    <a href="/indicadores">Volver</a>
<?php include(APPPATH.'Views/layouts/footer.php'); ?>