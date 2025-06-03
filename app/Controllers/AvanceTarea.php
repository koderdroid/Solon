// ...dentro de crear($tarea_id)
$nombreUsuario = session()->get('usuario_nombre') ?? 'anónimo';
$avanceModel->save([
    'tarea_id'     => $tarea_id,
    'indicador_id' => $this->request->getPost('indicador_id'),
    'periodo'      => $this->request->getPost('periodo'),
    'avance_texto' => $this->request->getPost('avance_texto'),
    'usuario'      => $nombreUsuario
]);