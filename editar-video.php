<?php
$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");

$id = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
if($id === false){
    header('Location: /?sucesso=0');
    exit();
}

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

$videoRepository = new \Alura\Mvc\Repository\VideoRepository($pdo);
$video = new \Alura\Mvc\Entity\Video($url, $titulo);
$video->setId($id);
if ($videoRepository->update($video)===false){
    header('Location: /?sucesso=0');
} else {
    header('Location: /?sucesso=1');
}