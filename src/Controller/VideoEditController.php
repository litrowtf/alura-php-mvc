<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\AtualizaImagem;
use Alura\Mvc\Entity\Video;
use Alura\Mvc\Helper\FlashMassageTrait;
use Alura\Mvc\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VideoEditController implements RequestHandlerInterface
{
    use FlashMassageTrait;

    public function __construct(private VideoRepository $videoRepository)
    {

    }

    //Lidar com as requisições (GET, POST, etc)
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = array_merge($request->getQueryParams(), $request->getParsedBody());
//        var_dump($queryParams);
//        exit();
        $id = filter_var($queryParams['id'], FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            $this->addErrorMassage('Id não encontrado');
            return new Response(302, [
                'Location' => '/editar-video'
            ]);
        }

        if ($_SERVER['PATH_INFO'] == '/remover-capa') {
            $this->videoRepository->removeCapa($id);
            return new Response(200, [
                'Location' => '/'
            ]);
        }
//        var_dump($queryParams);
//        exit();
        $url = filter_var($queryParams['url'], FILTER_VALIDATE_URL);
        if ($url === false) {
            $this->addErrorMassage('URL inválida');
            return new Response(302, [
                'Location' => '/editar-video'
            ]);
        }
//        $titulo = filter_input(INPUT_POST, 'titulo');
        $titulo = filter_var($queryParams['titulo']);
        if ($titulo === false) {
            $this->addErrorMassage('Título não informado');
            return new Response(302, [
                'Location' => '/editar-video'
            ]);
        }

        $video = new Video($url, $titulo);
        $video->setId($id);
        AtualizaImagem::atualiza($video, $request);

        $success = $this->videoRepository->update($video);

        if ($success === false) {
//            echo 'Erro VideoEditController';
            $this->addErrorMassage('Erro ao atualizar vídeo');
            return new Response(302, [
                'Location' => '/editar-video'
            ]);
        }

//      echo 'PASSOU VideoEditController';

        return new Response(302, [
            'Location' => '/'
        ]);

    }
}