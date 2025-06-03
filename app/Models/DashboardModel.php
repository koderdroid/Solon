public function historico_avance($periodos = ['2025-01','2025-02','2025-03','2025-04']) {
    $db = \Config\Database::connect();
    $areas = $db->table('areas')->select('id, nombre')->get()->getResultArray();
    $result = [];
    foreach($periodos as $p) {
        $row = ['periodo'=>$p,'areas'=>[]];
        foreach($areas as $a) {
            $av = $db->query("SELECT AVG(avance) avance FROM tarea_avance ta
                JOIN tareas t ON ta.tarea_id = t.id
                JOIN unidades u ON t.unidad_responsable_id = u.id
                WHERE u.area_id=? AND ta.periodo=?", [$a['id'],$p])->getRowArray();
            $row['areas'][$a['id']] = ['avance_fisico'=>floatval($av['avance']??0)];
        }
        $result[] = $row;
    }
    return $result;
}