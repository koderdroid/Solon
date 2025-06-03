<!-- ... tabla ... -->
<td>
    <button class="btn btn-link btn-detalle" onclick="verDetalleNotificacion(<?= $n['id'] ?>)">Ver</button>
    <?php if($n['estado']=='notificado_supervisor'): ?>
        <span class="badge bg-warning text-dark" title="Notificado a supervisor">Notificado Supervisor</span>
    <?php endif; ?>
</td>
<!-- ... -->