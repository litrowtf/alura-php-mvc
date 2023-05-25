<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

abstract class ControllerWithHtml implements Controller
{
    private const TEMPLATE_PATH = __DIR__ . '/../../views/';

    protected function renderTemplate(string $templateName, array $context = []): void
    {
        /* Função que transforma as chaves do array em variáveis
         * Ex: o array $context = ['videoList' => $videosList]
         * Irá extrair para uma variável $videosList (chave) os valores de $videosList (valor)
        */
        extract($context); // as variáveis poerão ser usadas nos contextos dos formulários
        require_once self::TEMPLATE_PATH . $templateName . '.php';
    }
}