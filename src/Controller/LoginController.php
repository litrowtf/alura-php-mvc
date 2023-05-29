<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

use Alura\Mvc\Helper\FlashMassageTrait;

class LoginController implements Controller
{
    use FlashMassageTrait;
    private \PDO $pdo;

    public function __construct()
    {
        $dbPath = __DIR__ . '/../../banco.sqlite';
        $this->pdo = new \PDO("sqlite:$dbPath");
        echo 'loginController';
    }

    public function processaRequisicao(): void
    {

        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        // Se ocorrer algum problema na captura da senha, gera um hash de uma senha inválida para faze a validação.
        // Essa implementação diminui o risco de Timing Attack.
        $password = filter_input(INPUT_POST, 'password' ?? password_hash(' ', PASSWORD_ARGON2ID));

        // Buscar usuário no banco usando e-mail
        $sql = 'SELECT * FROM users WHERE email = ?';
        $statment = $this->pdo->prepare($sql);
        $statment->bindValue(1, $email);
        $statment->execute();
        $userData = $statment->fetch(\PDO::FETCH_ASSOC);

        $correct_password = password_verify($password, $userData['password'] ?? '');

        if ($correct_password) {
            /* Verifica se o algorítimo utilizado no hash da senha é o definido no projeto.
             * Se não for, atualiza a senha com o hash especificado.
             */
            $algoritimoHash = PASSWORD_ARGON2ID;
            if (password_needs_rehash($userData['password'], $algoritimoHash)) {
                $statment = $this->pdo->prepare('UPDATE users SET password = ? WHERE id = ?;');
                $statment->bindValue(1, password_hash($password, $algoritimoHash));
                $statment->bindValue(2, $userData['id']);
                $statment->execute();
            }

            $_SESSION['logado'] = true;
            header('Location: /?sucesso=1');
        } else {
            $this->addErroMassage('Usuário ou senha inválidos');
            header('Location: /login');
        }


    }
}