<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

use Alura\Mvc\Helper\FlashMassageTrait;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

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

    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getParsedBody();
//        var_dump($queryParams);
        $email = filter_var($queryParams['email'], FILTER_VALIDATE_EMAIL);
        /* Se ocorrer algum problema na captura da senha, gera um hash de uma senha inválida para faze a validação.
        Essa implementação diminui o risco de Timing Attack. */
//        $password = filter_input(INPUT_POST, 'password' ?? password_hash(' ', PASSWORD_ARGON2ID));
        $password = filter_var($queryParams['password'] ?? password_hash(' ', PASSWORD_ARGON2ID));

        /* Buscar usuário */
        $sql = 'SELECT * FROM users WHERE email = ?';
        $statment = $this->pdo->prepare($sql);
        $statment->bindValue(1, $email);
        $statment->execute();
        $userData = $statment->fetch(\PDO::FETCH_ASSOC);

        /* Verifica senha */
        $correct_password = password_verify($password, $userData['password'] ?? '');
        if (!$correct_password) {
            $this->addErrorMassage('Usuário ou senha inválidos');
            return new Response(302, [
                'Location' => '/'
            ]);
        }

        /* Verifica se o algorítimo utilizado no hash da senha é o definido no projeto.
         * Se não for, atualiza a senha com o hash especificado. */
        $algoritimoHash = PASSWORD_ARGON2ID;
        if (password_needs_rehash($userData['password'], $algoritimoHash)) {
            $statment = $this->pdo->prepare('UPDATE users SET password = ? WHERE id = ?;');
            $statment->bindValue(1, password_hash($password, $algoritimoHash));
            $statment->bindValue(2, $userData['id']);
            $statment->execute();
        }

        $_SESSION['logado'] = true;
        return new Response(200, [
            'Location' => '/'
        ]);
    }
}