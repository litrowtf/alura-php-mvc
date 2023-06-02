<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;
use League\Plates\Engine;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VideoListController implements RequestHandlerInterface
{
    public function __construct(
        private VideoRepository $videoRepository,
        private Engine $templates
    )
    {

    }

    //Lidar com as requisições (GET, POST, etc)
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $videosList = $this->videoRepository->all();

        return new Response(200, body: $this->templates->render(
            'video-list',
            ['videosList' => $videosList]));
    }
}