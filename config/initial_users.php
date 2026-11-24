<?php

return [
    'admin' => [
        'name' => env('ADMIN_NAME', 'Administrateur'),
        'email' => env('ADMIN_EMAIL', 'admin1@gmail.com'),
        'password' => env('ADMIN_PASSWORD'),
    ],
    'staff' => [
        'name' => env('STAFF_NAME', 'Gestionnaire'),
        'email' => env('STAFF_EMAIL', 'admin2@gmail.com'),
        'password' => env('STAFF_PASSWORD'),
    ],
];