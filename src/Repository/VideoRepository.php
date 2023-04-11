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
            $slq = 'INSERT INTO videos (url, title) VALUES (?,?);';
            $statment = $this->pdo->prepare($slq);
            $statment->bindValue(1, $video->url);
            $statment->bindValue(2, $video->title);
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
        try {
            $sql = 'UPDATE videos SET url = :url, title = :title WHERE id = :id;';
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':url', $video->url);
            $statement->bindValue(':title', $video->title);
            $statement->bindValue(':id', $video->id, PDO::PARAM_INT);
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
//        var_dump($videoList);
        return array_map(function (array $videoData){
            $video = new Video($videoData['url'],$videoData['title']);
            $video->setId($videoData['id']);
            return $video;
        },
            $videoList);
    }
}