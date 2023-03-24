<?php

$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");

/**
 * As variáveis $_GET e $_POST são chamdas "superglobais", pois são gerenciadas pelo próprio PHP e vêm juntas com a
 *requisição. Neste exemplo, serão capturadas as informações passadas nos campos do formulário de nome "url" e "titulo".
 */

//echo "{$_POST['url']} --- {$_POST['titulo']}";
//exit();

$slq = 'INSERT INTO videos (url, title) VALUES (?,?);';
$statmet = $pdo->prepare($slq);
$statmet->bindValue(1,$_POST['url']);
$statmet->bindValue(2,$_POST['titulo']);

var_dump($statmet->execute());