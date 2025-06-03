<?php

namespace App\Controllers;

use App\Models\IndicadorModel;
use CodeIgniter\Controller;

class Indicadores extends Controller
{
    public function index()
    {
        $model = new IndicadorModel();
        $data['indicadores'] = $model->findAll();
        return view('indicadores/index', $data);
    }

    public function ver($id)
    {
        $model = new IndicadorModel();
        $data['indicador'] = $model->find($id);
        return view('indicadores/ver', $data);
    }

    public function crear()
    {
        helper(['form', 'url']);
        $model = new IndicadorModel();

        if ($this->request->getMethod() === 'post') {
            $model->save([
                'codigo' => $this->request->getPost('codigo'),
                'nombre' => $this->request->getPost('nombre'),
                'formula' => $this->request->getPost('formula'),
                'meta' => $this->request->getPost('meta'),
                'area' => $this->request->getPost('area'),
                'descripcion' => $this->request->getPost('descripcion'),
                'tipo' => $this->request->getPost('tipo'),
            ]);
            return redirect()->to('/indicadores');
        }

        return view('indicadores/crear');
    }
}