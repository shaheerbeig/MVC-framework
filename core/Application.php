<?php

namespace app\core;
use app\core\Router;
use app\core\Request;
use app\core\Statuscode;
class Application{

    public static Application $app;
    public Router $router;
    public Request $request;
    public Statuscode $status;
    public Statuscode $response;
    public Database $db;
    public static string $rootPath;
    public function __construct($rootDirectory,$configuration){
        $this->request = new Request();
        $this->router = new Router($this->request);
        $this->status = new Statuscode();
        $this->response = new Statuscode();
        $this->db = new Database($configuration);
        self::$app = $this;
        self::$rootPath=$rootDirectory;
    }

    public function run(){
        echo $this->router->resolve();
    }
};