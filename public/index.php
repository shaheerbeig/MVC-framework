<?php
use app\controller\Authcontroller;
use app\core\Application;
use app\controller\Sitecontroller;

require_once  '../vendor/autoload.php';
$rootDirectory = dirname(__DIR__);
echo $rootDirectory;
$app = new Application($rootDirectory);
$app->router->get('/',[Sitecontroller::class, 'home']);
$app->router->get('/contact', [Sitecontroller::class, 'contact']);
$app->router->post('/contact', [Sitecontroller::class, 'HomeControllerRender']);

$app->router->get('/register', [Authcontroller::class, 'register']);
$app->router->post('/register', [Authcontroller::class, 'register']);
$app->router->get('/login', [Authcontroller::class, 'login']);
$app->router->post('/login', [Authcontroller::class, 'login']);

$app->run();
