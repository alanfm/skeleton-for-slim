<?php

$configs = [    
    'determineRouteBeforeAppMiddleware' => true,
    'displayErrorDetails'               => true,
    'addContentLengthHeader'            => true,
    'db' => [
        'driver'    => getenv('DB_DRIVER'),
        'host'      => getenv('DB_HOST'),
        'database'  => getenv('DB_NAME'),
        'username'  => getenv('DB_USER'),
        'password'  => getenv('DB_PASS'),
        'charset'   => getenv('DB_CHARSET'),
        'collation' => getenv('DB_COLLATION'),
        'prefix'    => getenv('DB_PREFIX'),
    ]
];