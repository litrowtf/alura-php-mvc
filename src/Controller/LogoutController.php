<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LogoutController implements Controller
{
    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface
    {
//       session_destroy();
//       header('Location: /login');
        unset($_SESSION['logado']);
        return new Response(302, [
            'Location' => '/login'
        ]);

       /* Também pode ser utilizado umas das alternativas abaixo
        * $_SESSION['logado'] = false;
        * unset($_SESSION['logado']);
        *
        * Isso é mais seguro, pois a destruição de sessões pode trazer resultados inesperados em casos de
        * requisições concorrentes
        *
        */
    }
}