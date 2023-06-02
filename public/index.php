<?php

//echo phpinfo();

declare(strict_types=1);

use Alura\Mvc\Controller\{
    Error404Controller,};
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

require_once __DIR__ . '/../vendor/autoload.php';
$routes = require_once __DIR__ . '/../config/routes.php';
/** @var ContainerInterface $diContainer */
$diContainer = require_once __DIR__ . '/../config/dependencies.php';


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
    $controller = $diContainer->get($controllerClass);
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

/** @var RequestHandlerInterface $controller */
$response = $controller->handle($request);
http_response_code($response->getStatusCode());
foreach ($response->getHeaders() as $name => $values){
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}

echo $response->getBody();