<?php

//echo phpinfo();

declare(strict_types=1);

use Alura\Mvc\Controller\{
    Error404Controller,
    Controller};
use Alura\Mvc\Repository\VideoRepository;

require_once __DIR__ . '/../vendor/autoload.php';
$routes = require_once __DIR__ . '/../config/routes.php';

$dbPath = __DIR__ . '/../banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");
$videoRepository = new VideoRepository($pdo);
$pathInfo = $_SERVER['PATH_INFO'] ?? '/'; //se a pathinfo não existir, ela será a "/"
$httpMethod = $_SERVER['REQUEST_METHOD'];

// É necessário o session_start() para utilizar a variável $_SESSION
session_start();
//A cada nova requisição, um novo ID de sessão será gerado
session_regenerate_id();
$isLoginRoute = $pathInfo === '/login'; //Evitar erro TOO_MANY_REDIRECTS
if(!array_key_exists('logado', $_SESSION) && !$isLoginRoute){
    header('Location: /login');// O header deve conter o cabeçalho (Location) e a URL (/login)
    return;
}

$key = "$httpMethod|$pathInfo";

if (array_key_exists($key, $routes)) {
    $controllerClass = $routes["$httpMethod|$pathInfo"];
    /** @var Controller $controller */
    $controller = new $controllerClass($videoRepository);
} else{
    $controller = new Error404Controller();
}

$psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();

$creator = new \Nyholm\Psr7Server\ServerRequestCreator(
    $psr17Factory,
    $psr17Factory,
    $psr17Factory,
    $psr17Factory,
);

$request = $creator->fromGlobals();

/** @var Controller $controller */
$response = $controller->processaRequisicao($request);
http_response_code($response->getStatusCode());
foreach ($response->getHeaders() as $name => $values){
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}

echo $response->getBody();