<?php
namespace App\Controllers;

use App\Models\PoaFormulario1Model;
use CodeIgniter\Controller;

class PoaFormulario1 extends Controller
{
    /**
     * Guardado seguro de Formulario 1 para etapa de Formulación y Seguimiento.
     * Permite edición solo de campos permitidos (acción corto plazo, producto, metas/avance periodo editable)
     * Nunca borra datos históricos ni texto de la gestión vigente.
     */
    public function guardar()
    {
        helper(['form', 'url']);
        $model = new PoaFormulario1Model();

        // Solo usuarios autorizados
        if (!session()->get('isLoggedIn') || !session()->get('usuario_rol') === 'planificador') {
            return redirect()->to('/auth/login');
        }

        // Se espera que los datos lleguen como: accion_corto_plazo[id], producto[id], avance_2025[id][periodo]
        $accion_corto_plazo = $this->request->getPost('accion_corto_plazo');
        $producto = $this->request->getPost('producto');
        $prog_2025 = $this->request->getPost('prog_2025');
        $avance_2025 = $this->request->getPost('avance_2025'); // [id][periodo]
        $periodo_edicion = $this->request->getPost('periodo_edicion'); // 'Prog.', 'Feb', etc.

        // Guardado seguro: actualiza solo campos editados y NO sobrescribe si no hay cambio
        foreach ($accion_corto_plazo as $id => $texto) {
            $actual = $model->getById($id);
            if ($actual && $actual['accion_corto_plazo'] !== $texto) {
                $model->update($id, ['accion_corto_plazo' => $texto]);
            }
        }
        foreach ($producto as $id => $texto) {
            $actual = $model->getById($id);
            if ($actual && $actual['producto'] !== $texto) {
                $model->update($id, ['producto' => $texto]);
            }
        }
        // Prog. 2025 (programación de meta anual, solo editable en Formulación inicial)
        foreach ($prog_2025 as $id => $valor) {
            $model->guardarMeta2025($id, $valor);
        }
        // Avances por periodo (solo el periodo editable se puede modificar)
        if (isset($avance_2025) && is_array($avance_2025)) {
            foreach ($avance_2025 as $id => $periodos) {
                foreach ($periodos as $periodo => $valor) {
                    if ($periodo == $periodo_edicion) {
                        $model->guardarAvance2025($id, $periodo, $valor);
                    }
                }
            }
        }
        // Regresar a la vista con mensaje de éxito
        return redirect()->to('/poa/formulario1?guardado=1');
    }
}