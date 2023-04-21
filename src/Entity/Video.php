<?php

declare(strict_types=1);

namespace Alura\Mvc\Entity;

class Video
{
    //Pode ler, mas só pode atribuir o valor uma vez
    public readonly int $id;
    public readonly string $url;

    public function __construct(
        string $url,
        public readonly string $title) //recebe e define a propriedade "titulo"
    {
        $this->setUrl($url);
    }

    private function setUrl(string $url): void
    {
        //verifica se a URL é inválida e lança exception
        if (!filter_var($url, FILTER_VALIDATE_URL)){
            throw new \InvalidArgumentException('Erro setUrl()');
        }
        $this->url = $url;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

}