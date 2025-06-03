<?php
$title = "Listado de Indicadores";
include(APPPATH.'Views/layouts/header.php');
?>
    <h2>Listado de Indicadores</h2>
    <a href="/indicadores/crear" class="btn">Nuevo Indicador</a>
    <table id="tablaIndicadores" class="display">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Área</th>
                <th>Meta</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($indicadores as $ind): ?>
            <tr>
                <td><?= esc($ind['codigo']) ?></td>
                <td><a href="/indicadores/ver/<?= $ind['id'] ?>"><?= esc($ind['nombre']) ?></a></td>
                <td><?= esc($ind['area']) ?></td>
                <td><?= esc($ind['meta']) ?></td>
                <td><a href="/indicadores/ver/<?= $ind['id'] ?>">Ver</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <script>
        $(function() {
            $('#tablaIndicadores').DataTable();
        });
    </script>
<?php include(APPPATH.'Views/layouts/footer.php'); ?>