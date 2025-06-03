<?php
namespace App\Models;
use CodeIgniter\Model;

class IndicadoresModel extends Model
{
    // Ejemplo: KPIs principales y tendencias (cargar desde BD real)
    public function getKPIs() {
        // Simulación: En producción, calcular con SQL y datos reales
        $actual_fisico = 97.16;
        $anterior_fisico = 96.5;
        $actual_financiero = 98.24;
        $anterior_financiero = 97.8;
        return [
            'fisico' => $actual_fisico,
            'financiero' => $actual_financiero,
            'fisico_tendencia' => $actual_fisico - $anterior_fisico,
            'financiero_tendencia' => $actual_financiero - $anterior_financiero,
            'comentario_tendencia' => ($actual_fisico > $anterior_fisico ? 'Avance físico al alza.' : ($actual_fisico < $anterior_fisico ? 'Avance físico en descenso.' : 'Avance físico estable.'))
        ];
    }
    // Indicador: Recursos TGN (MM Bs)
    public function getIndicadorRecursosTGN() {
        // Simulación: en real, consultar tabla recursos_anuales
        $labels = ['2018','2019','2020','2021','2022','2023','2024'];
        $values = [19.28, 28.37, 5.22, 16.11, 7.76, 20.98, 7.77];
        $desc = "A diciembre de 2025: se generaron recursos económicos a favor del TGN en un total de Bs7.767.387,15 por concepto de recuperación de Activos Exigibles, entre otros...";
        return [
            'labels' => $labels,
            'values' => $values,
            'descripcion' => $desc
        ];
    }
    // Indicador: Certificaciones SICEPA
    public function getIndicadorSICEPA() {
        $labels = ['2018','2019','2020','2021','2022','2023','2024'];
        $values = [1167, 3158, 2812, 2834, 239, 1762, 1003];
        $desc = "Al primer trimestre de 2025: 1.003 certificados a favor de 128 entidades públicas...";
        return [
            'labels' => $labels,
            'values' => $values,
            'descripcion' => $desc
        ];
    }
    // Indicador: Certificaciones CIBID
    public function getIndicadorCIBID() {
        $labels = ['2018','2019','2020','2021','2022','2023','2024'];
        $values = [2266, 2018, 2005, 1781, 1988, 1983, 1802];
        $desc = "A diciembre de 2025: se emitieron 1.802 certificaciones...";
        return [
            'labels' => $labels,
            'values' => $values,
            'descripcion' => $desc
        ];
    }
    // Puedes agregar más métodos para otros indicadores...
}