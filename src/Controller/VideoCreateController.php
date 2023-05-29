<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\AtualizaImagem;
use Alura\Mvc\Entity\Video;
use Alura\Mvc\Helper\FlashMassageTrait;
use Alura\Mvc\Repository\VideoRepository;

class VideoCreateController implements Controller
{
    use FlashMassageTrait;
    public function __construct(private VideoRepository $videoRepository)
    {

    }

    //Lidar com as requisições (GET, POST, etc)
    public function processaRequisicao(): void
    {

        $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
        if ($url === false) {
            $this->addErroMassage('URL inválida');
            header('Location: /novo-video');
            return;
        }
        $titulo = filter_input(INPUT_POST, 'titulo');
        if ($titulo === false) {
            $this->addErroMassage('Título não informado');
            header('Location: /novo-video');
            return;
        }

        $video = new Video($url, $titulo);
        AtualizaImagem::atualiza($video);

        $success = $this->videoRepository->add($video);
        if ($success === false) {
            $this->addErroMassage('Erro ao cadastrar vídeo');
            header('Location: /novo-video');
        } else {
            header('Location: /?sucesso=1');
        }
    }

}