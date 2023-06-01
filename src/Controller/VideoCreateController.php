<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\AtualizaImagem;
use Alura\Mvc\Entity\Video;
use Alura\Mvc\Helper\FlashMassageTrait;
use Alura\Mvc\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class VideoCreateController implements Controller
{
    use FlashMassageTrait;
    public function __construct(private VideoRepository $videoRepository)
    {

    }

    //Lidar com as requisições (GET, POST, etc)
    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface
    {

        $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
        if ($url === false) {
            $this->addErrorMassage('URL inválida');
            return new Response(302, [
                'Location' => '/novo-video'
            ]);
        }
        $titulo = filter_input(INPUT_POST, 'titulo');
        if ($titulo === false) {
            $this->addErrorMassage('Título não informado');
            return new Response(302, [
                'Location' => '/novo-video'
            ]);
        }

        $video = new Video($url, $titulo);
        AtualizaImagem::atualiza($video, $request);

        $success = $this->videoRepository->add($video);
        if ($success === false) {
            $this->addErrorMassage('Erro ao cadastrar vídeo');
            return new Response(302, [
                'Location' => '/novo-video'
            ]);
        } else {
            return new Response(200, [
                'Location' => '/'
            ]);
        }
    }

}