<?php

namespace app\core\Middlewares;
use app\core\Application;
use app\core\exception\RestrictedException;

class AuthMiddleware extends GeneralMiddleware{
    public array $actions = [];

    public function __construct(array $actionsPerform = []){
        $this->actions = array_merge($this->actions, $actionsPerform);
    }

    public function execute(){

        if(Application::guestUser()){
            if(in_array(Application::$app->controller->action,$this->actions) || empty($this->actions)){
                throw new RestrictedException();
            }
        }
    }
};  