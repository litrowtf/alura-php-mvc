<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;
use PDO;

class VideoListController extends ControllerWithHtml implements Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {

    }

    //Lidar com as requisições (GET, POST, etc)
    public function processaRequisicao(): void
    {
        $videosList = $this->videoRepository->all();

        $this->renderTemplate(
            'video-list',
            ['videosList' => $videosList]
        );

    }
}