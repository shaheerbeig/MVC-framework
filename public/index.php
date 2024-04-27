<?php
use app\controller\Authcontroller;
use app\core\Application;
use app\controller\Sitecontroller;

require_once  '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$rootDirectory = dirname(__DIR__);
$configuration = [
    'db'=> [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD']
    ]
];
$app = new Application($rootDirectory,$configuration['db']);

$app->router->get('/',[Sitecontroller::class, 'home']);
$app->router->get('/contact', [Sitecontroller::class, 'contact']);
$app->router->post('/contact', [Sitecontroller::class, 'HomeControllerRender']);

$app->router->get('/register', [Authcontroller::class, 'register']);
$app->router->post('/register', [Authcontroller::class, 'register']);
$app->router->get('/login', [Authcontroller::class, 'login']);
$app->router->post('/login', [Authcontroller::class, 'login']);

$app->run();
