<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;
use PDO;

class VideoCreateController implements Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {

    }

    //Lidar com as requisições (GET, POST, etc)
    public function processaRequisicao(): void
    {

        $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
        if ($url === false) {
            header('Location: /?sucesso=0');
            return;
        }
        $titulo = filter_input(INPUT_POST, 'titulo');
        if ($titulo === false) {
            header('Location: /?sucesso=0');
            return;
        }

        $success = $this->videoRepository->add(new Video($url, $titulo));
        if ($success === false) {
            header('Location: /?sucesso=0');
        } else {
            header('Location: /?sucesso=1');
        }
    }

}