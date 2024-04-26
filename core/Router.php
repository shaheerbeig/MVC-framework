<?php

namespace app\core;
class Router{
    //this array will store the callback function against the requested url/paths.
    protected array $storeRoutes = [];
    public Request $request;

    public function __construct(Request $request){
        $this->request = $request;
    }
    public function register($request,$path , $callback){
        $this->storeRoutes[$request][$path] = $callback;
    }
    public function get(string $path ,$callback){
        $this->register("get",$path,$callback);
    }
    public function post($path , $callback){
        $this->register("post",$path,$callback);
    }
    public function resolve(){
        $requestedURL = $this->request->getPath();
        $method = $this->request->getmethod();
        
        $callback = $this->storeRoutes[$method][$requestedURL] ?? false;
        try{
            if ($callback === false) {
                Application::$app->status->setresposeCode(404);
                return $this->ErrorRender("Error 404");
            }

            if (is_string($callback)) {
                return $this->render($callback);
            }

            if (is_array($callback)) {
                $callback[0] = new $callback[0]();
            }
            return call_user_func($callback);

        }catch(\Exception $e){
            echo "Exception thrown " . $e->getMessage();
        }
    }
    public function ErrorRender($view){
        $layout = $this->pageLayout();
        return str_replace('{{content}}',$view,$layout);
    }

    public function render($view) {
        $layout = $this->pageLayout();
        $viewContent = $this->viewOnly($view);
        return str_replace('{{content}}', $viewContent, $layout);
    }
    
    protected function pageLayout(){
        ob_start();
        require_once Application::$rootPath .  "/view/layouts/mainlayout.php";
        return ob_get_clean();
    }

    protected function viewOnly($view){
        $filepath = Application::$rootPath .  "/view/$view.php";
        ob_start();
        require_once $filepath;
        return ob_get_clean();
    }
};