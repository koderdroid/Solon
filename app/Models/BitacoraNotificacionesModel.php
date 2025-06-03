<?php
namespace App\Models;
use CodeIgniter\Model;

class BitacoraNotificacionesModel extends Model
{
    protected $table = 'bitacora_notificaciones';

    // ... otros métodos ...

    /**
     * Obtiene notificaciones sin gestionar después de X días
     * @param int $dias Número de días límite
     * @return array
     */
    public function getNoGestionadasXDias($dias = 3)
    {
        $limite = date('Y-m-d H:i:s', strtotime("-{$dias} days"));
        return $this->where('estado!=', 'gestionado')
            ->where('fecha_envio <=', $limite)
            ->findAll();
    }
}