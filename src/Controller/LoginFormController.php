<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

use League\Plates\Engine;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginFormController implements RequestHandlerInterface
{

    public function __construct(private Engine $templates)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Para não exibir a página de login novamente quando o usuário já estive logado

        if (array_key_exists('logado', $_SESSION) && $_SESSION['logado'] === true) { //tenta acessar a chave logado, se não conseguir retorna falso
            header('Location: /');
            return new Response(302, [
                'Location' => '/'
            ]);
        }
        return new Response(200, body: $this->templates->render('login-form'));
    }
}