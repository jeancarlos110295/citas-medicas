<?php

return [
    'horarios_permitidos' => [
        [
            'inicio' => explode('-', env('HORARIO_MANANA', '07:00-12:00'))[0],
            'fin'    => explode('-', env('HORARIO_MANANA', '07:00-12:00'))[1],
        ],
        [
            'inicio' => explode('-', env('HORARIO_TARDE', '14:00-18:00'))[0],
            'fin'    => explode('-', env('HORARIO_TARDE', '14:00-18:00'))[1],
        ],
    ]
];
