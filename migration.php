<?php

use app\core\Application;

require_once  __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$rootDirectory = __DIR__;
$configuration = [
    'db'=> [
        'dbname' => $_ENV['DB_DATABASE'],
        'host' => $_ENV['DB_HOST'],
        'port' => $_ENV['DB_PORT'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD']
    ]
];
$app = new Application($rootDirectory,$configuration['db']);
$app->db->apply();