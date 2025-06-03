<?php
$title = "Ver Indicador";
include(APPPATH.'Views/layouts/header.php');
?>
    <h2><?= esc($indicador['nombre']) ?></h2>
    <strong>Código:</strong> <?= esc($indicador['codigo']) ?><br>
    <strong>Área:</strong> <?= esc($indicador['area']) ?><br>
    <strong>Tipo:</strong> <?= esc($indicador['tipo']) ?><br>
    <strong>Fórmula:</strong> <?= nl2br(esc($indicador['formula'])) ?><br>
    <strong>Meta:</strong> <?= esc($indicador['meta']) ?><br>
    <strong>Descripción:</strong><br>
    <p><?= nl2br(esc($indicador['descripcion'])) ?></p>
    <a href="/indicadores">Volver</a>
<?php include(APPPATH.'Views/layouts/footer.php'); ?>