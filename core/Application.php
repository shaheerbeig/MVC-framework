<?php

namespace app\core;
use app\core\Router;
use app\core\Dbmap;
use app\core\Request;
use app\core\Statuscode;
class Application{
    public string $title = '';
    public static Application $app;
    public Router $router;
    public Request $request;
    public Statuscode $status;
    public Statuscode $response;
    public Database $db;
    public Sessions $session;
    public Controllers $controller;
    public ?Dbmap $user;
    public string $class;
    public static string $rootPath;
    public function __construct($rootDirectory,$configuration){
        $this->request = new Request();
        $this->router = new Router($this->request);
        $this->status = new Statuscode();
        $this->response = new Statuscode();
        $this->session = new Sessions();
        $this->db = new Database($configuration['db']);
        self::$app = $this;
        self::$rootPath=$rootDirectory;

        $this->class = $configuration['user'];
        $primaryValue = $this->session->get('user');

        if($primaryValue){
            $primaryKey = $this->class::getIdentifier();
            $this->user = $this->class::findUser([$primaryKey => $primaryValue]);
        }
        else{
            $this->user = null;
        }
    }

    public function run(){
        echo $this->router->resolve();
    }

    public function login(Dbmap $user){
        $this->user = $user;
        $primarykey = $user::getIdentifier();
        $primaryValue = $user->{$primarykey};
        $this->session->set('user',$primaryValue);
    }

    public function logout(){
        $this->user = null;
        Application::$app->session->remove('user');
    }
    public static function guestUser(){
        return !self::$app->user;
    }
};