<?php
namespace App\Controllers;

class InformeFinanciero extends BaseController
{
    public function index()
    {
        // --- Datos de ejemplo, cargar reales de BD ---
        $cierre_entes = [
            ['gestion'=>'2008','fondos'=>'2 FCSS Ferroviario Red Oriental, 3 FCSS Ferroviario Red Occidental, 4 FCSS de CORDECRUZ, FCSS Municipal La Paz, 6 Fondo de Pensiones Municipal Santa Cruz, 7 FCSS de Corporaciones de Desarrollo'],
            ['gestion'=>'2009','fondos'=>'1 FCSS de Comunicaciones, 2 FCSS de Terminales Rodoviarios Fiscales Bolivianos, 3 FCSS de Profesionales de la Minería Nacional'],
            ['gestion'=>'2010','fondos'=>'1 FCSS de Aduanas, 2 FCSS de la Educación, 3 FCSS Metalúrgico – Oruro'],
            ['gestion'=>'2011','fondos'=>'1 FCSS de la Caja Nacional de Salud, 2 FCSS Municipal Cochabamba'],
            ['gestion'=>'2012','fondos'=>'1 Fondo de Pensiones de Trabajadores del Banco Agrícola de Bolivia'],
            ['gestion'=>'2013','fondos'=>'1 FCSS de la Caja Petrolera de Salud'],
            ['gestion'=>'2015, 2016','fondos'=>'1 Fondo de Privatización de la Banca Estatal'],
            ['gestion'=>'2017, 2018','fondos'=>'1 FCSS Médico y Ramas Anexas'],
            ['gestion'=>'2019, 2020, 2021','fondos'=>'1 FCSS Aeronáuticas y E.A.'],
            ['gestion'=>'2023, 2024','fondos'=>'1 FCSS de la Administración Pública'],
        ];
        $modificaciones = [
            [
                'resolucion'=>'SNPE/RA/DGE-011/2024',
                'fecha'=>'26 de abril de 2024',
                'tecnico'=>'SNPE/IN/DAF-037-UF/2024',
                'legal'=>'SNPE/IN/DJ-060-UAJ/2024',
                'importe'=>'51,327.70',
                'marcador'=>'i',
                'comentario'=>'Espacios para comentarios y aclaración .'
            ],
            [
                'resolucion'=>'SNPE/RA/DGE-026/2024',
                'fecha'=>'6 de noviembre de 2024',
                'tecnico'=>'SNPE/IN/DAF-150-UF/2024',
                'legal'=>'SNPE/IN/DJ-192-UAJ/2024',
                'importe'=>'234,473.00',
                'marcador'=>'ii',
                'comentario'=>'Espacios para comentarios y aclaración.'
            ]
        ];
        $presupuesto_inicial = [
            ['actividad'=>'06 Gestión y Fortalecimiento SENAPE','presupuesto'=>'13.784.258,50'],
            ['actividad'=>'07 Liquidación de Entes Gestores de la Seguridad Social','presupuesto'=>'4.452.027,00'],
            ['actividad'=>'10 Disposición de Bienes y Recuperación de Activos Exigibles','presupuesto'=>'2.718.744,50'],
            ['actividad'=>'93 Inserción laboral personas con discapacidad**','presupuesto'=>'418.303,00'],
        ];
        $presupuesto_total = '21.403.687,00';
        $ejecucion_presupuesto = [
            ['actividad'=>'06 Gestión y Fortalecimiento Servicio Nacional de Patrimonio del Estado','vigente'=>'13.784.258,50','ejecutado'=>'13.535.080,07','porcentaje'=>'98,19%'],
            ['actividad'=>'07 Liquidación de Entes Gestores de la Seguridad Social','vigente'=>'4.452.027,00','ejecutado'=>'4.378.047,90','porcentaje'=>'98,34%'],
            ['actividad'=>'10 Disposición de Bienes y Recuperación de Activos Exigibles','vigente'=>'2.718.744,50','ejecutado'=>'2.680.394,84','porcentaje'=>'98,59%'],
            ['actividad'=>'93 Inserción laboral personas con discapacidad**','vigente'=>'418.303,00','ejecutado'=>'412.329,71','porcentaje'=>'98,57%'],
        ];
        $ejecucion_total = [
            'vigente'=>'21.373.333,00',
            'ejecutado'=>'21.373.333,00',
            'porcentaje'=>'98,28%'
        ];
        return view('informe_financiero_graficos', compact(
            'cierre_entes',
            'modificaciones',
            'presupuesto_inicial',
            'presupuesto_total',
            'ejecucion_presupuesto',
            'ejecucion_total'
        ));
    }
}