<div class="modal-header">
    <h5 class="modal-title">Detalle de Notificación (ID: <?= esc($n['id']) ?>)</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
</div>
<div class="modal-body">
    <b>Periodo:</b> <?= esc($n['periodo']) ?><br>
    <b>Unidad:</b> <?= esc($n['unidad_id']) ?><br>
    <b>Área:</b> <?= esc($n['area_id']) ?><br>
    <b>Destino:</b> <?= esc($n['usuario_destino']) ?><br>
    <b>Asunto:</b> <?= esc($n['asunto']) ?><br>
    <b>Fecha de envío:</b> <?= esc($n['fecha_envio']) ?><br>
    <b>Tipo:</b> <?= esc($n['tipo']) ?><br>
    <b>Estado:</b> <?= esc($n['estado']) ?><br>
    <?php if($n['fecha_lectura']): ?>
        <div class="alert alert-info mt-2"><b>Leído por:</b> <?= esc($n['usuario_lectura']) ?> el <?= esc($n['fecha_lectura']) ?></div>
    <?php endif; ?>
    <?php if($n['fecha_gestion']): ?>
        <div class="alert alert-success mt-2"><b>Gestionado por:</b> <?= esc($n['usuario_gestion']) ?> el <?= esc($n['fecha_gestion']) ?><br>
        <b>Observación:</b> <?= esc($n['observacion_gestion']) ?></div>
    <?php endif; ?>
    <hr>
    <b>Cuerpo del mensaje:</b>
    <pre style="white-space:pre-line"><?= esc($n['cuerpo']) ?></pre>
    <?php if($n['detalles']): ?>
        <hr>
        <b>Detalles adicionales:</b>
        <pre style="white-space:pre-line"><?= esc(json_encode(json_decode($n['detalles']), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)) ?></pre>
    <?php endif; ?>
    <?php
    $esDestino = session()->get('user')['username'] == $n['usuario_destino'];
    ?>
    <?php if($esDestino && !$n['fecha_lectura']): ?>
        <button class="btn btn-primary mt-2" onclick="confirmarLectura(<?= $n['id'] ?>)">Confirmar Lectura</button>
        <script>
        function confirmarLectura(id) {
            fetch("/resultados-desviaciones/confirmarLecturaNotificacion/"+id)
              .then(r=>r.json()).then(data=>{ if(data.ok) location.reload(); });
        }
        </script>
    <?php endif; ?>
    <?php if($esDestino && !$n['fecha_gestion']): ?>
        <form onsubmit="return gestionarNoti(this);">
            <div class="form-group mt-3">
                <label>Observación/Acción tomada:</label>
                <textarea name="observacion_gestion" class="form-control" required></textarea>
                <input type="hidden" name="id" value="<?= esc($n['id']) ?>">
            </div>
            <button class="btn btn-success mt-2" type="submit">Confirmar Gestión de la Alerta</button>
        </form>
        <script>
        function gestionarNoti(form) {
            let fd = new FormData(form);
            fetch("/resultados-desviaciones/confirmarGestionNotificacion", {
                method: "POST", body: fd
            }).then(r=>r.json())
              .then(data=>{ if(data.ok) location.reload(); });
            return false;
        }
        </script>
    <?php endif; ?>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
</div>