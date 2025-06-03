// Edición rápida de avance y cumplimiento en dashboard POA
$(document).on('change', '.input-avance, .input-cumplido, .input-obs', function() {
    const $row = $(this).closest('tr');
    const tarea_id = $row.data('tarea-id');
    const avance = $row.find('.input-avance').val();
    const cumplido = $row.find('.input-cumplido').is(':checked') ? 1 : 0;
    const obs = $row.find('.input-obs').val();
    const periodo = $('#filtro_periodo').val() || ''; // Puedes agregar filtro de periodo si lo tienes

    $.post('/dashboard-poa/actualizarTareaAvance', {
        tarea_id, avance_porcentaje: avance, estado_cumplimiento: cumplido, observaciones: obs, periodo
    }, function(resp) {
        if (resp.ok) {
            $row.addClass('guardado');
            setTimeout(function(){ $row.removeClass('guardado'); }, 600);
        }
    }, 'json');
});