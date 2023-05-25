<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

class LoginFormController extends ControllerWithHtml implements Controller
{

    public function processaRequisicao(): void
    {
        // Para não exibir a página de login novamente quando o usuário já estive logado
        if (array_key_exists('logado', $_SESSION) && $_SESSION['logado'] === true) { //tenta acessar a chve logado, se não conseguir retorna falso
            header('Location: /');
            return;
        }
        $this->renderTemplate('login-form');
    }
}