<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

class LoginController implements Controller
{
    private \PDO $pdo;

    public function __construct()
    {
        $dbPath = __DIR__ . '/../../banco.sqlite';
        $this->pdo = new \PDO("sqlite:$dbPath");
        echo 'loginController';
    }

    public function processaRequisicao(): void
    {
        $email = filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST,'password');

        // Buscar usuário no banco usando e-mail
        $sql = 'SELECT * FROM users WHERE email = ?';
        $statment = $this->pdo->prepare($sql);
        $statment->bindValue(1,$email);
        $statment->execute();
        $userData = $statment->fetch(\PDO::FETCH_ASSOC);

        $correct_password = password_verify($password,$userData['password'] ?? '');

        if ($correct_password){
            $_SESSION['logado'] = true;
            header('Location: /?sucesso=1');
        } else{
            header('Location: /login?sucesso=0');
        }


    }
}