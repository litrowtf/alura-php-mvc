<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;
use PDO;

class VideoEditController
{
    public function __construct(private VideoRepository $videoRepository)
    {

    }

    //Lidar com as requisições (GET, POST, etc)
    public function processaRequisicao(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {//FORMULÁRIO EDIÇÃO DE VÍDEO
            $id = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
            $video = $this->videoRepository->find($id);

            require_once __DIR__ . '/../../inicio-html.php';?>
            <main class="container">
                <form class="container__formulario"
                      method="post">
                    <h2 class="formulario__titulo">Envie um vídeo!</h2>
                    <div class="formulario__campo">
                        <label class="campo__etiqueta" for="url">Link embed</label>
                        <input name="url"
                               value="<?=$video->url;?>"
                               class="campo__escrita"
                               required
                               placeholder="Por exemplo: https://www.youtube.com/embed/FAY1K2aUg5g"
                               id='url' />
                    </div>


                    <div class="formulario__campo">
                        <label class="campo__etiqueta" for="titulo">Titulo do vídeo</label>
                        <input name="titulo"
                               value="<?=$video->title;?>"
                               class="campo__escrita"
                               required
                               placeholder="Neste campo, dê o nome do vídeo"
                               id='titulo' />
                    </div>

                    <input class="formulario__botao" type="submit" value="Enviar" />
                </form>

            </main>
            <?php require_once __DIR__ . '/../../fim-html.php';
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') { //SALVAR EDIÇÃO DE VÍDEO
            $id = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
            if($id === false){
                header('Location: /?sucesso=0');
                exit();
            }

            $url = filter_input(INPUT_POST, 'url',FILTER_VALIDATE_URL);
            if ($url===false){
                header('Location: /?sucess=0');
                exit();
            }

            $titulo = filter_input(INPUT_POST,'titulo');
            if ($titulo===false){
                header('Location: /?sucess=0');
                exit();
            }

            $video = new Video($url, $titulo);
            $video->setId($id);
            if ($this->videoRepository->update($video)===false){
                header('Location: /?sucesso=0');
            } else {
                header('Location: /?sucesso=1');
            }
        }
    }
}