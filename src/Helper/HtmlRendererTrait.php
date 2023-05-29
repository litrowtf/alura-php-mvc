<?php

declare(strict_types=1);

namespace Alura\Mvc\Helper;

trait HtmlRendererTrait
{
    private function renderTemplate(string $templateName, array $context = []): string
    {
        $templatePath = __DIR__ . '/../../views/';
        /* Função que transforma as chaves do array em variáveis
         * Ex: o array $context = ['videoList' => $videosList]
         * Irá extrair para uma variável $videosList (chave) os valores de $videosList (valor)
        */
        extract($context); // as variáveis poderão ser usadas no contexto das páginass
        ob_start(); //inicia buffer
        require_once $templatePath . $templateName . '.php';
        return ob_get_clean();//exibe o buffer e limpa
    }

}