<?php

namespace app\core;
use app\core\Middlewares\GeneralMiddleware;

class Controllers{
    public array $Middlewares = [];
    public string $action = '';
    //this function is responsible for registering the middleware passed from the controller class.
    public function registermiddleware(GeneralMiddleware $middleware){
        $this->Middlewares[] = $middleware;
    }
};