<?php

declare(strict_types=1);

namespace Alura\Mvc\Entity;

class Video
{
    //Pode ler, porém só pode atribuir o valor uma vez
    public readonly string $url;
    public readonly int $id;

    public function __construct(
        string $url,
        public readonly string $title) //recebe e define a propriedade "titulo"
    {
        $this->setUrl($this->url);
    }

    private function setUrl(string $url): void
    {
        //verifica se a URL não é válida e lança exception
        if (filter_var($url,FILTER_VALIDATE_URL)===false){
            throw new \InvalidArgumentException();
        }

        $this->url=$url;

    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

}