<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class IndicadoresSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // 6.1 Estratégicos
            [
                'codigo' => 'IE-CDBE',
                'nombre' => 'Indicador Estratégico de Cumplimiento a la Declaración Jurada de Bienes del Estado',
                'formula' => '(Entidades Públicas que presentaron la DEJURBE finalizada en el plazo / Entidades Públicas habilitadas para realizar la DEJURBE) x 100',
                'meta' => '≥ 95%',
                'area' => 'General',
                'tipo' => 'estrategico',
                'descripcion' => ''
            ],
            [
                'codigo' => 'IC-GRTGN',
                'nombre' => 'Indicador Complementario de Generación de Recursos Para el TGN',
                'formula' => '(Ingreso de recursos generados, verificados / Recursos generados para el TGN) x 100',
                'meta' => '≥ 95%',
                'area' => 'General',
                'tipo' => 'estrategico',
                'descripcion' => ''
            ],
            [
                'codigo' => 'IQCGIE',
                'nombre' => 'Indicador Quinquenal de Cumplimiento a la Gestión Institucional Eficiente',
                'formula' => '(ICAGE x0.15 + ICAAFA x0.15 + ICAAFSEPOA x0.14 + ICAATI x0.14 + ICAAAF x0.14 + ICAPJTC x0.14 + ICAPOAOD x0.14) x 100',
                'meta' => '≥ 90%',
                'area' => 'General',
                'tipo' => 'estrategico',
                'descripcion' => ''
            ],
            [
                'codigo' => 'IQCTLCCCI',
                'nombre' => 'Indicador Quinquenal de Cumplimiento de Transparencia, Lucha Contra la Corrupción y Control Interno',
                'formula' => '(IACTLCC x0.34 + IACDVEHC x0.33+ IACCII x 0.33) x 100',
                'meta' => '≥ 90%',
                'area' => 'General',
                'tipo' => 'estrategico',
                'descripcion' => ''
            ],
            // 6.2 Complementarios y de Proceso (solo algunos ejemplos, el resto en sql/indicadores.sql)
            [
                'codigo' => 'IACGE',
                'nombre' => 'Indicador Anual de Cumplimiento a la Gestión Eficiente',
                'formula' => '(Avance Físico Institucional / Avance Financiero Institucional) x 100',
                'meta' => '≥ 90%',
                'area' => 'SENAPE',
                'tipo' => 'complementario',
                'descripcion' => ''
            ],
            [
                'codigo' => 'IACAFSEPOA',
                'nombre' => 'Indicador Anual de Cumplimiento del Avance Físico, Seguimiento y Evaluación al POA',
                'formula' => '(Porcentaje de ejecución del POA / POA Programado) x 100',
                'meta' => '≥ 90%',
                'area' => 'SENAPE',
                'tipo' => 'complementario',
                'descripcion' => ''
            ],
            // ... (más indicadores generales aquí, el resto en el insert masivo)
        ];

        // Insertar todos los registros
        $this->db->table('indicadores')->insertBatch($data);
    }
}