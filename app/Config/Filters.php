<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Filters extends BaseConfig
{
    public $aliases = [
        'csrf'     => \CodeIgniter\Filters\CSRF::class,
        'toolbar'  => \CodeIgniter\Filters\DebugToolbar::class,
        'honeypot' => \CodeIgniter\Filters\Honeypot::class,
        'auth'     => \App\Filters\AuthFilter::class,
    ];

    public $globals = [
        'before' => [
            // 'csrf',
            // 'honeypot'
        ],
        'after'  => [
            'toolbar',
        ],
    ];

    public $methods = [];
    public $filters = [
        'auth' => [
            'before' => [
                '/',
                'indicadores*',
                'poa-tareas*',
                'avance-tarea*',
            ]
        ]
    ];
}