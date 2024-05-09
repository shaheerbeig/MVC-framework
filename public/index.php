<?php
use app\controller\Authcontroller;
use app\core\Application;
use app\controller\Sitecontroller;

require_once  '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$rootDirectory = dirname(__DIR__);
$configuration = [
    'user' => app\model\users::class,
    'db'=> [
        'dbname' => $_ENV['DB_DATABASE'],
        'host' => $_ENV['DB_HOST'],
        'port' => $_ENV['DB_PORT'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD']
    ]
];
$app = new Application($rootDirectory,$configuration);

$app->router->get('/',[Sitecontroller::class, 'home']);
$app->router->get('/contact', [Sitecontroller::class, 'contact']);
$app->router->post('/contact', [Sitecontroller::class, 'contact']);

$app->router->get('/register', [Authcontroller::class, 'register']);
$app->router->post('/register', [Authcontroller::class, 'register']);
$app->router->get('/login', [Authcontroller::class, 'login']);
$app->router->post('/login', [Authcontroller::class, 'login']);
$app->router->get('/logout', [Authcontroller::class, 'logout']);
$app->router->get('/profile', [Authcontroller::class, 'profile']);
$app->run();
