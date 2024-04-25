<?php

namespace app\controller;
use app\core\Application;

class Authcontroller{
    public function login(){
        return Application::$app->router->render('login');
    }

    public function register(){
        return Application::$app->router->render('register');
    }
};