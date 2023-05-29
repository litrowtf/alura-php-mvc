<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\AtualizaImagem;
use Alura\Mvc\Entity\Video;
use Alura\Mvc\Helper\FlashMassageTrait;
use Alura\Mvc\Repository\VideoRepository;

class VideoEditController
{
    use FlashMassageTrait;
    public function __construct(private VideoRepository $videoRepository)
    {

    }

    //Lidar com as requisições (GET, POST, etc)
    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            $this->addErroMassage('Id não encontrado');
            header('Location: /editar-video');
            return;
        }

        if($_SERVER['PATH_INFO'] == '/remover-capa'){
            $this->videoRepository->removeCapa($id);
            header('Location: /?sucesso=1');
            return;
        }

        $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
        if ($url === false) {
            $this->addErroMassage('URL inválida');
            header('Location: /editar-video');
            return;
        }
        $titulo = filter_input(INPUT_POST, 'titulo');
        if ($titulo === false) {
            $this->addErroMassage('Título não informado');
            header('Location: /editar-video');
            return;
        }

        $video = new Video($url, $titulo);
        $video->setId($id);
        AtualizaImagem::atualiza($video);

        $success = $this->videoRepository->update($video);

        if ($success === false) {
            $this->addErroMassage('Erro ao atualizar vídeo');
            header('Location: /editar-video');
        } else {
            header('Location: /?sucesso=1');
        }
    }
}