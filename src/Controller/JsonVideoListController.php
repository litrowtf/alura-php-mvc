<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class JsonVideoListController implements RequestHandlerInterface
{
    public function __construct(private VideoRepository $videoRepository)
    {

    }

    //Lidar com as requisições (GET, POST, etc)
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // A listagem de vídeos captudaras em videoRepository->all() é passada para a função anônima como objeto e essa
        // função retorna as propriedades da entidade Video na forma de array associativo. O retorno é armazenado em
        // $videoList
        $videosList = array_map(function (Video $video): array{
            return [
                'url' => $video->url,
                'title'=> $video->title,
                'file_path' => '/img/uploads/' . $video->getFilePath(),
            ];
        }, $this->videoRepository->all());

        //Tranformando a resposta em um Json
//        echo json_encode($videosList);
        return new Response(200, [
            'Content-Type' => 'application/json'
            ], json_encode($videosList));
    }
}