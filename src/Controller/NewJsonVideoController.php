<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;
use PDO;


/** Enviar requisição pelo Postman
 * EX:
 * Método: POST
 * Endereço: http://localhost:8000/videos
 * JSON:
        {
        "url": "https://www.youtube.com/embed/e-WakfBNHD0",
        "title": "Test POST"
        }
 * Obs: Configurar Cookie:
 * Ex:
 * Domínio: localhost
 * PHPSESSID=ofga6c41blr5crjb9l97pis26c; Path=/;
 */

class NewJsonVideoController
{
    public function __construct(private VideoRepository $videoRepository)
    {

    }

    //Lidar com as requisições (GET, POST, etc)
    public function processaRequisicao(): void
    {
        $request = file_get_contents('php://input');
        $videoData = json_decode($request, true); //segundo parâmetro setado para retornar em forma de array associativo
        $video = new Video($videoData['url'], $videoData['title']);
        $this->videoRepository->add($video);

        //Status CREATED = 201
        http_response_code(201);
    }
}