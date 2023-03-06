<?php

include 'vendor/autoload.php';
require 'app/lib/Dev.php';
use app\core\Router;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


$router = new Router();
$router->run();
