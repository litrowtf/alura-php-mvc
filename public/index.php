<?php

//echo var_dump($_SERVER);

declare(strict_types=1);

use Alura\Mvc\Controller\VideoCreateController;
use Alura\Mvc\Controller\VideoEditController;
use Alura\Mvc\Controller\VideoListController;
use Alura\Mvc\Controller\VideoRemoveController;
use Alura\Mvc\Repository\VideoRepository;

require_once __DIR__ . '/../vendor/autoload.php';

$dbPath = __DIR__ . '/../banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");
$videoRepository = new VideoRepository($pdo);

if(!array_key_exists('PATH_INFO',$_SERVER) //LISTAR TODOS OS VÍDEOS
    || $_SERVER['PATH_INFO'] === '/'){
    $controller = new VideoListController($videoRepository);
    $controller->processaRequisicao();
} elseif ($_SERVER['PATH_INFO'] === '/novo-video'){ //ADICIONAR VÍDEO
    $controller = new VideoCreateController($videoRepository);
    $controller->processaRequisicao();
}  elseif ($_SERVER['PATH_INFO'] === '/editar-video') { //EDITAR VÍDEO
    $controller = new VideoEditController($videoRepository);
    $controller->processaRequisicao();
} elseif ($_SERVER['PATH_INFO'] === '/remover-video') { //REMOVER UM VÍDEOS
    $controller = new VideoRemoveController($videoRepository);
    $controller->processaRequisicao();
} else{
    http_response_code(404);
}