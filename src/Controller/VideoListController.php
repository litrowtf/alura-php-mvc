<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Helper\HtmlRendererTrait;
use Alura\Mvc\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class VideoListController implements Controller
{
    use HtmlRendererTrait;

    public function __construct(private VideoRepository $videoRepository)
    {

    }

    //Lidar com as requisições (GET, POST, etc)
    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface
    {
        $videosList = $this->videoRepository->all();

        return new Response(200, body: $this->renderTemplate(
            'video-list',
            ['videosList' => $videosList]));
    }
}