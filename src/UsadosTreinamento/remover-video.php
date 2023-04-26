<?php

$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");

$id = $_GET['id'];

$videoRepository = new \Alura\Mvc\Repository\VideoRepository($pdo);
if ($videoRepository->remove($id)===false){
    header('Location: /?sucesso=0');
} else {
    header('Location: /?sucesso=1');
}