<?php

namespace app\core;
use app\core\Statuscode;
class Router{
    //this array will store the callback function against the requested url/paths.
    protected array $storeRoutes = [];

    public function register($request,$path , $callback){
        $this->storeRoutes[$request][$path] = $callback;
    }
    public function get(string $path ,$callback){
        $this->register("get",$path,$callback);
    }

    public function post($path , $callback){
        $this->register("post",$path,$callback);
    }

    public function resolve($method,$requestedURL){
        $callback = $this->storeRoutes[$method][$requestedURL] ?? false;
        
        if($callback === false){
            Application::$app->status->setresposeCode(404);
            return  $this->ErrorRender("Error 404");
        }
        else{

            //this means that the function assocaited to a particular request is not a callback function rather a string so we will render the 
            //string.
            if(is_string($callback)){
                return $this->render($callback);
            }
            else{
                return  call_user_func($callback);
            }
        }
    }
    public function ErrorRender($view){
        $layout = $this->pageLayout();
        return str_replace('{{content}}',$view,$layout);
    }

    public function render($view){
        $layout = $this->pageLayout();
        $viewLayout = $this->viewOnly($view);
        return str_replace('{{content}}',$viewLayout,$layout);
    }
    protected function pageLayout(){
        ob_start();
        require_once Application::$rootPath .  "/view/layouts/mainlayout.php";
        return ob_get_clean();
    }

    protected function viewOnly($view){
        ob_start();
        require_once Application::$rootPath .  "/view/$view.php";
        return ob_get_clean();
    }
};