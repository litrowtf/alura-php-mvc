<?php

declare(strict_types=1);

namespace Alura\Mvc\Entity;

use Alura\Mvc\Repository\VideoRepository;

class  AtualizaImagem
{

    public static function atualiza(Video &$video): void
    {
        //Verifica se houve erro no upload
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            //Inicia teste de tipo do arquivo
            $finfo = new \finfo(FILEINFO_MIME_TYPE);

            //Guardo o tipo do arquivo em $mineType
            $mineType = $finfo->file($_FILES['image']['tmp_name']);

            //Verifica se o arquivo é uma imagem
            if (str_starts_with($mineType, 'image/')){
                //Criar um nome único para o arquivo de upload para evitar problemas com arquivos de mesmo nome
                $uniqid = uniqid('upload_');
                //Cria um nome seguro, para evitar a injeção de código malicioso
                $pathinfo = pathinfo($_FILES['image']['name'], PATHINFO_BASENAME);
//                $pathinfo = basename($_FILES['image']['name']); // Alternativa do código acima

                    //Nome de arquivo seguro
                $safeFileName = $uniqid . $pathinfo;
                //Caso não ocorra erros, move o rquivo para um local acessível
                move_uploaded_file(
                    $_FILES['image']['tmp_name'],
                    __DIR__ . '/../../public/img/uploads/' . $safeFileName
                );
                $video->setFilePath($safeFileName); //Definindo o filePath
            }
        }
    }
}