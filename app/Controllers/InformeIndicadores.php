<?php
namespace App\Controllers;

class InformeIndicadores extends BaseController
{
    public function index()
    {
        // Simulados - en real, cargar desde BD
        $cumplimiento_dejurbe = [
            ['gestion'=>'2018','universo'=>617,'declararon'=>600,'porc_declaracion'=>'97,24','incremento'=>'-1,11','certificaciones'=>3],
            ['gestion'=>'2019','universo'=>622,'declararon'=>617,'porc_declaracion'=>'99,20','incremento'=>'1,95','certificaciones'=>4],
            ['gestion'=>'2020','universo'=>615,'declararon'=>602,'porc_declaracion'=>'97,89','incremento'=>'-1,31','certificaciones'=>4],
            ['gestion'=>'2021','universo'=>620,'declararon'=>620,'porc_declaracion'=>'100','incremento'=>'2,11','certificaciones'=>4],
            ['gestion'=>'2022','universo'=>617,'declararon'=>617,'porc_declaracion'=>'100','incremento'=>'0,00','certificaciones'=>4],
            ['gestion'=>'2023','universo'=>617,'declararon'=>617,'porc_declaracion'=>'100','incremento'=>'0,00','certificaciones'=>4],
            ['gestion'=>'2024','universo'=>619,'declararon'=>619,'porc_declaracion'=>'100','incremento'=>'0,00','certificaciones'=>4],
        ];
        $inmuebles = [
            ['gestion'=>'2018','definitivo'=>18713,'otro'=>15280,'sin'=>9342,'total'=>43335],
            ['gestion'=>'2019','definitivo'=>20232,'otro'=>15397,'sin'=>9067,'total'=>44696],
            ['gestion'=>'2020','definitivo'=>22520,'otro'=>13931,'sin'=>9063,'total'=>45514],
            ['gestion'=>'2021','definitivo'=>24164,'otro'=>13451,'sin'=>8932,'total'=>46547],
            ['gestion'=>'2022','definitivo'=>25680,'otro'=>13149,'sin'=>8689,'total'=>47518],
            ['gestion'=>'2023','definitivo'=>27109,'otro'=>12906,'sin'=>8704,'total'=>48719],
            ['gestion'=>'2024','definitivo'=>28322,'otro'=>12333,'sin'=>8514,'total'=>50569],
        ];
        $parque = [
            ['gestion'=>'2018','definitivo'=>23915,'otro'=>7728,'sin'=>6912,'total'=>38555],
            ['gestion'=>'2019','definitivo'=>25261,'otro'=>7842,'sin'=>6871,'total'=>39974],
            ['gestion'=>'2020','definitivo'=>26828,'otro'=>7361,'sin'=>6823,'total'=>41012],
            ['gestion'=>'2021','definitivo'=>27897,'otro'=>7102,'sin'=>6738,'total'=>41737],
            ['gestion'=>'2022','definitivo'=>28696,'otro'=>7012,'sin'=>6267,'total'=>41975],
            ['gestion'=>'2023','definitivo'=>29844,'otro'=>7134,'sin'=>6120,'total'=>41975],
            ['gestion'=>'2024','definitivo'=>31204,'otro'=>7154,'sin'=>6332,'total'=>44690],
        ];
        $sicepa = [
            ['gestion'=>'2018','certificaciones'=>1167,'entidades'=>122],
            ['gestion'=>'2019','certificaciones'=>3158,'entidades'=>121],
            ['gestion'=>'2020','certificaciones'=>2812,'entidades'=>78],
            ['gestion'=>'2021','certificaciones'=>2834,'entidades'=>83],
            ['gestion'=>'2022','certificaciones'=>1109,'entidades'=>139],
            ['gestion'=>'2023','certificaciones'=>1762,'entidades'=>159],
            ['gestion'=>'2024','certificaciones'=>1003,'entidades'=>128],
        ];
        $cibid = [
            ['gestion'=>'2018','certificaciones'=>2266,'entidades'=>190],
            ['gestion'=>'2019','certificaciones'=>2018,'entidades'=>189],
            ['gestion'=>'2020','certificaciones'=>2005,'entidades'=>171],
            ['gestion'=>'2021','certificaciones'=>1781,'entidades'=>172],
            ['gestion'=>'2022','certificaciones'=>1988,'entidades'=>187],
            ['gestion'=>'2023','certificaciones'=>1983,'entidades'=>189],
            ['gestion'=>'2024','certificaciones'=>1802,'entidades'=>200],
        ];
        $recuperaciones = [
            ['gestion'=>'2018','acumulado'=>'19.281.800,08','recuperaciones'=>'13.695.891,39','transferencia'=>'856,34','deposito'=>''],
            ['gestion'=>'2019','acumulado'=>'28.372.998,29','recuperaciones'=>'2.865.302,65','transferencia'=>'865.302,65','deposito'=>''],
            ['gestion'=>'2020','acumulado'=>'5.217.011,24','recuperaciones'=>'1.137.455,69','transferencia'=>'','deposito'=>'36.646,03'],
            ['gestion'=>'2021','acumulado'=>'16.114.279,66','recuperaciones'=>'147.056,34','transferencia'=>'','deposito'=>''],
            ['gestion'=>'2022','acumulado'=>'7.763.441,92','recuperaciones'=>'418.903,50','transferencia'=>'','deposito'=>'6.324,10'],
            ['gestion'=>'2023','acumulado'=>'20.976.749,56','recuperaciones'=>'','transferencia'=>'','deposito'=>''],
            ['gestion'=>'2024','acumulado'=>'7.767.387,15','recuperaciones'=>'23.267,48','transferencia'=>'','deposito'=>''],
        ];
        return view('informe_indicadores_graficos', compact(
            'cumplimiento_dejurbe','inmuebles','parque','sicepa','cibid','recuperaciones'
        ));
    }
}