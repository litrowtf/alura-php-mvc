<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;
use League\Plates\Engine;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VideoFormController implements RequestHandlerInterface
{

    public function __construct(
        private VideoRepository $videoRepository,
        private Engine          $templates
    )
    {

    }

    //Lidar com as requisições (GET, POST, etc)
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
//        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $queryParams = $request->getQueryParams() ?? '';
        $id = filter_var($queryParams['id'], FILTER_VALIDATE_INT);
        /** @var ?Video $video */
        $video = null;
        if ($id !== false && $id !== null) {
            $video = $this->videoRepository->find($id);
        }
        return new Response(200,
            body: $this->templates->render(
                'video-form',
                [
                    'id' => $id,
                    'video' => $video
                ]));

    }
}