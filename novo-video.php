<?php

use Alura\Mvc\Repository\VideoRepository;

$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");

/**
 * As variáveis $_GET e $_POST são chamdas "superglobais", pois são gerenciadas pelo próprio PHP e vêm juntas com a
 *requisição. Neste exemplo, serão capturadas as informações passadas nos campos do formulário de nome "url" e "titulo".
 */

//Testa se a url passada é válida. Se não for, redireciona para mensagem de erro e encerra a execução do script
$url = filter_input(INPUT_POST, 'url',FILTER_VALIDATE_URL);
if ($url===false){
    header('Location: /?sucess=0');
    exit();
}

$titulo = filter_input(INPUT_POST,'titulo');
if ($titulo===false){
    header('Location: /?sucess=0');
    exit();
}

$videoRepository = new VideoRepository($pdo);

if ($videoRepository->add(new \Alura\Mvc\Entity\Video($url, $titulo))===false){
    //Redirecionamento de página
    header('Location: /?sucess=0');
} else{
    //Redirecionamento de página - bem sucedido
    header('Location: /?sucess=1');
}
