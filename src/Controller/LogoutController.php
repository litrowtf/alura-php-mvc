<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

class LogoutController implements Controller
{
    public function processaRequisicao(): void
    {
       session_destroy();
       header('Location: /login');

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