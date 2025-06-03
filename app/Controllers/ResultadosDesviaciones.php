<?php
namespace App\Controllers;
use App\Models\BitacoraNotificacionesModel;

class ResultadosDesviaciones extends BaseController
{
    // ... otros métodos ...

    /**
     * Automatiza notificación a supervisores si una alerta no es gestionada en X días
     * Programar esta función por cron o tarea programada.
     */
    public function notificarSupervisoresNoGestionadas($dias = 3)
    {
        $bitacora = new BitacoraNotificacionesModel();
        $no_gestionadas = $bitacora->getNoGestionadasXDias($dias);

        // Supón que tienes un modelo para obtener emails de supervisores por unidad/área:
        // (puedes adaptar según tu modelo real)
        $supervisores = $this->getSupervisoresEmails(); // array [unidad_id => email, ...]

        $email = \Config\Services::email();
        $enviadas = 0;
        foreach($no_gestionadas as $n) {
            $unidad = $n['unidad_id'];
            $area = $n['area_id'];
            $destino = $supervisores[$unidad] ?? $supervisores[$area] ?? null;
            if ($destino) {
                $subject = "ALERTA: Reporte POA sin gestionar más de {$dias} días - {$unidad}";
                $msg = "Estimado/a supervisor,\n\n";
                $msg .= "Se detecta que la alerta (ID: {$n['id']}) para la unidad {$unidad} y área {$area} del periodo {$n['periodo']} no ha sido gestionada después de {$dias} días.\n\n";
                $msg .= "Asunto: {$n['asunto']}\n";
                $msg .= "Fecha de envío: {$n['fecha_envio']}\n";
                $msg .= "Detalle:\n{$n['cuerpo']}\n\n";
                $msg .= "Por favor, realice el seguimiento correspondiente.\n\nSistema de Alertas POA";
                $email->setTo($destino);
                $email->setSubject($subject);
                $email->setMessage($msg);
                $sent = $email->send();

                // Opcional: marca el estado como 'notificado_supervisor'
                $bitacora->update($n['id'], ['estado'=>'notificado_supervisor']);
                $enviadas++;
            }
        }
        return "Notificaciones a supervisores enviadas: $enviadas";
    }

    /**
     * Mock: Obtiene emails de supervisores (ajusta a tu modelo real)
     */
    private function getSupervisoresEmails()
    {
        // Ejemplo: deberías consultar tu tabla de usuarios/roles reales
        return [
            'DRP' => 'supervisor.drp@ejemplo.gob.bo',
            'DAF' => 'supervisor.daf@ejemplo.gob.bo',
            'DBRAE' => 'supervisor.dbrae@ejemplo.gob.bo',
            // ...
        ];
    }
}