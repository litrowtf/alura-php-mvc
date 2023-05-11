<?php

declare(strict_types=1);

namespace Alura\Mvc\Entity;

use Alura\Mvc\Repository\VideoRepository;

class  AtualizaImagem
{

    public static function atualiza(Video &$video): void
    {
        //Verifica se houve erro no upload
        if($_FILES['image']['error'] === UPLOAD_ERR_OK){
            //Caso não ocorra erros, move o rquivo para um local acessível
            move_uploaded_file(
                $_FILES['image']['tmp_name'],
                __DIR__ . '/../../public/img/uploads/' . $_FILES['image']['name']
            );
            $video->setFilePath($_FILES['image']['name']); //Definindo o filePath
        }
    }
}