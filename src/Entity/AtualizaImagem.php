<?php

declare(strict_types=1);

namespace Alura\Mvc\Entity;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UploadedFileInterface;

class  AtualizaImagem
{

    public static function atualiza(Video &$video, ServerRequestInterface $request): void
    {
        //Verifica se houve erro no upload
        $files = $request->getUploadedFiles();
        /** @var UploadedFileInterface $uploadedImage */
        $uploadedImage = $files['image'];
        if ($uploadedImage->getError() === UPLOAD_ERR_OK) {
            //Inicia teste de tipo do arquivo
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $tmpFile = $uploadedImage->getStream()->getMetadata('uri');
            //Guardo o tipo do arquivo em $mineType
            $mineType = $finfo->file($tmpFile);

            //Verifica se o arquivo é uma imagem
            if (str_starts_with($mineType, 'image/')){
                //Criar um nome único para o arquivo de upload para evitar problemas com arquivos de mesmo nome
                $uniqid = uniqid('upload_');
                //Cria um nome seguro, para evitar a injeção de código malicioso
                $pathinfo = pathinfo($_FILES['image']['name'], PATHINFO_BASENAME);
//                $pathinfo = basename($_FILES['image']['name']); // Alternativa do código acima

                    //Nome de arquivo seguro
                $safeFileName = $uniqid . $pathinfo;
                //Caso não ocorra erros, move o arquivo para um local acessível
                $uploadedImage->moveTo(__DIR__ . '/../../´public/img/uploads' . $safeFileName);
                $video->setFilePath($safeFileName); //Definindo o filePath
            }
        }
    }
}