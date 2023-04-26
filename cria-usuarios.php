<?php

declare(strict_types=1);

$dbPatth = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$dbPatth");

$email = $argv[1];
$pass = $argv[2];
$hash = password_hash($pass, PASSWORD_ARGON2ID);
$statement = $pdo->prepare("INSERT INTO users (email, password) VALUES (?,?)");
$statement->bindValue(1, $email);
$statement->bindValue(2, $hash);
$statement->execute();