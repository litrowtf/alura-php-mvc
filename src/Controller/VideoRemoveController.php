<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;
use PDO;

class VideoRemoveController
{
    public function __construct(private VideoRepository $videoRepository)
    {

    }

    //Lidar com as requisições (GET, POST, etc)
    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
        if ($this->videoRepository->remove($id)===false){
            header('Location: /?sucesso=0');
        } else{
            header('Location: /?sucesso=1');
        }
    }
}