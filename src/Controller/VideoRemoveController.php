<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

use Alura\Mvc\Helper\FlashMassageTrait;
use Alura\Mvc\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class VideoRemoveController implements Controller
{
    use FlashMassageTrait;

    public function __construct(private VideoRepository $videoRepository)
    {

    }

    //Lidar com as requisições (GET, POST, etc)
    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $id = filter_var($queryParams['id'], FILTER_VALIDATE_INT);
        if ($id === null || $id === false) {
            $this->addErrorMassage('ID inválido');
            return new Response(302,[ // Status de redirecionamento
                'Location' => '/'
            ]);
        }

        $success = $this->videoRepository->remove($id);
        if ($success === false) {
            $this->addErrorMassage('Erro ao remover vídeo');
            return new Response(302,[ // Status de redirecionamento
                'Location' => '/'
            ]);
        } else {
            return new Response(302, [
                'Location' => '/'
            ]);
        }
    }
}