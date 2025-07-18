<?php

use App\Core\Middlewares\Auth;
$middlewares = [

    'auth' => Auth::class,
    
];

return $middlewares;