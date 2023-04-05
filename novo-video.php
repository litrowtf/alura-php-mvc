<?php

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

$slq = 'INSERT INTO videos (url, title) VALUES (?,?);';
$statmet = $pdo->prepare($slq);
$statmet->bindValue(1,$_POST['url']);
$statmet->bindValue(2,$_POST['titulo']);

if ($statmet->execute()===false){
    //Redirecionamento de página
    header('Location: /?sucess=0');
} else{
    //Redirecionamento de página
    header('Location: /?sucess=1');
}
