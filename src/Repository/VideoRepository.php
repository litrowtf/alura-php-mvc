<?php

namespace Alura\Mvc\Repository;

use Alura\Mvc\Entity\Video;
use PDO;
class VideoRepository
{


    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function add(Video $video): bool
    {
        try {
            $slq = 'INSERT INTO videos (url, title, image_path) VALUES (?,?,?);';
            $statment = $this->pdo->prepare($slq);
            $statment->bindValue(1, $video->url);
            $statment->bindValue(2, $video->title);
            $statment->bindValue(3, $video->getFilePath());
            $result = $statment->execute();
            $id = $this->pdo->lastInsertId();
            $video->setId(intval($id));
            return $result;
        } catch (\PDOException $exception){
            echo "Erro ao inserir vídeo: " . $exception->getMessage();
            return false;
        }
    }

    public function remove(int $id): bool
    {
        try {
            $sql = 'DELETE FROM videos WHERE id = ?';
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(1, $id);
            return $statement->execute();
        } catch (\PDOException $exception){
            echo "Erro ao remover vídeo: " . $exception->getMessage();
            return false;
        }
    }

    public function update(Video $video): bool
    {
        $updatePath = '';
        $atualizaFilePath = $video->getFilePath()!==null;
        if($atualizaFilePath){
            $updatePath = ', image_path = :image_path ';
        }
        try {
            $sql = "UPDATE videos SET url = :url, title = :title $updatePath WHERE id = :id;";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':url', $video->url);
            $statement->bindValue(':title', $video->title);
            $statement->bindValue(':id', $video->id, PDO::PARAM_INT);
            if($atualizaFilePath){
                $statement->bindValue(':image_path', $video->getFilePath());
            }
            return $statement->execute();
        } catch (\PDOException $e) {
            echo "Erro ao editar vídeo: " . $e->getMessage();
            return false;
        }
    }

    public function removeCapa(int $idVideo): bool
    {
        try {
            $sql = "UPDATE videos SET image_path = null WHERE id = ?;";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(1, $idVideo);
            return $statement->execute();
        } catch (\PDOException $e) {
            echo "Erro ao editar vídeo: " . $e->getMessage();
            return false;
        }
    }

    /**
     * @return Video[]
     */
    public function all(): array
    {
        $videoList = $this->pdo
            ->query('SELECT * FROM videos;')
            ->fetchAll(PDO::FETCH_ASSOC);
        return array_map(
            $this->hydrateVideo(...),
            $videoList
        );
    }

    //Busca um vídeo por ID
    public function find(int $id): Video
    {
        $statement = $this->pdo->prepare('SELECT * FROM videos WHERE id = ?;');
        $statement->bindValue(1,$id, PDO::PARAM_INT);
        $statement->execute();
        return $this->hydrateVideo($statement->fetch(PDO::FETCH_ASSOC));
    }

    public function hydrateVideo(array $videoData): Video
    {
        $video = new Video($videoData['url'], $videoData['title']);
        $video->setId($videoData['id']);
        if($videoData['image_path'] !== null){
            $video->setFilePath($videoData['image_path']);
        }
        return $video;
    }
}