<?php

namespace app\controller;
use app\core\Application;
use app\core\Controllers;
use app\core\Request;
use app\model\users;
use app\model\userlogin;
use app\core\Middlewares\AuthMiddleware;

class Authcontroller extends Controllers{

    public function __construct(){
        $this->registermiddleware(new AuthMiddleware(['profile']));
    }

    public function login(Request $request){
        
        $userLogin = new userlogin();

        if($request->getmethod() === 'post'){
            $userLogin->LoadData($request->getBody());

            if($userLogin->validateData() && @$userLogin->login()){
                header('Location:/profile');
                exit();
            }
        }
        return Application::$app->router->render('login',[
            'model' => $userLogin
        ]);
    }

    public function register(Request $request){
        $registration = new users();

        if($request->getmethod() === 'post'){
            $registration->LoadData($request->getBody());

            if($registration->validateData() && $registration->saveUser()){
                //first argument => key
                //second argument => message
                //third argument => type of flash
                Application::$app->session->createFlash('success','Thanks For Registeration','success');
                header('Location: /');
                exit();
            }
        }
        return Application::$app->router->render('register',[
            'model' => $registration
        ]);
    }

    public function logout(Request $request){
        Application::$app->logout();
        header('Location: /');
    }

    public function profile(){
        return Application::$app->router->render('profile');
    }
};