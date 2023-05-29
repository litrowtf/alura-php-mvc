<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Helper\HtmlRendererTrait;
use Alura\Mvc\Repository\VideoRepository;
use PDO;

class VideoListController implements Controller
{
    use HtmlRendererTrait;

    public function __construct(private VideoRepository $videoRepository)
    {

    }

    //Lidar com as requisições (GET, POST, etc)
    public function processaRequisicao(): void
    {
        $videosList = $this->videoRepository->all();

        echo $this->renderTemplate(
            'video-list',
            ['videosList' => $videosList]
        );

    }
}