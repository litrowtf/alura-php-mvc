<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;
use PDO;

class VideoCreateController
{
    public function __construct(private VideoRepository $videoRepository)
    {

    }

    //Lidar com as requisições (GET, POST, etc)
    public function processaRequisicao(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {//FORMULÁRIO PARA CADASTRO DE NOVO VÍDEO
            require_once __DIR__ . '/../../inicio-html.php';?>
            <main class="container">

                <form class="container__formulario"
                      method="post">
                    <h2 class="formulario__titulo">Envie um vídeo!</h2>
                    <div class="formulario__campo">
                        <label class="campo__etiqueta" for="url">Link embed</label>
                        <input name="url"
                               class="campo__escrita"
                               required
                               placeholder="Por exemplo: https://www.youtube.com/embed/FAY1K2aUg5g"
                               id='url' />
                    </div>


                    <div class="formulario__campo">
                        <label class="campo__etiqueta" for="titulo">Titulo do vídeo</label>
                        <input name="titulo"
                               class="campo__escrita"
                               required
                               placeholder="Neste campo, dê o nome do vídeo"
                               id='titulo' />
                    </div>

                    <input class="formulario__botao" type="submit" value="Enviar" />
                </form>

            </main>
        <?php require_once __DIR__ . '/../../fim-html.php';
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') { //SALVAR NOVO VÍDEO
            //Testa se a url passada é válida. Se não for, redireciona para mensagem de erro e encerra a execução do script
            $url = filter_input(INPUT_POST, 'url',FILTER_VALIDATE_URL);
            if ($url===false){
                header('Location: /?sucess=0');
                exit();
            }
            //Testa se o título passado é válido
            $titulo = filter_input(INPUT_POST,'titulo');
            if ($titulo===false){
                header('Location: /?sucess=0');
                exit();
            }
            if ($this->videoRepository->add(new Video($url, $titulo))===false){
                header('Location: /?sucess=0');//Redirecionamento - Sem sucesso
            } else{
                header('Location: /?sucess=1');//Redirecionamento - Com sucesso
            }
        }
    }

}