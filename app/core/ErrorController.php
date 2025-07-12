<?php

namespace App\core;

class ErrorController 
{
    public function error404() 
    {
        http_response_code(404);
        require_once __DIR__ . "/../../config/error/error.html";
    }
    
    public function error500() 
    {
        http_response_code(500);
        require_once __DIR__ . "/../../config/error/error500.html";
    }
}
