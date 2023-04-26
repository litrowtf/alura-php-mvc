<?php

declare(strict_types=1);

$dbPatth = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$dbPatth");
$pdo->exec('CREATE TABLE users (id INTEGER PRIMARY KEY, email TEXT, password TEXT);');



