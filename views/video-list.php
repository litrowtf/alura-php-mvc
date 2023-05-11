<?php
/**@var Video[] $videosList*/ //<-- Comando para a IDE reconhecer a $vídeoList como um array de Video

use Alura\Mvc\Entity\Video;

require_once 'inicio-html.php';?>
<ul class="videos__container" alt="videos alura">
    <?php foreach ($videosList as $video):?>
        <?php if(str_starts_with($video->url, 'http')): ?>
            <li class="videos__item">
                <?php if($video->getFilePath() !== null):?>
                <a href="<?= $video->url; ?>">
                    <img src="/img/uploads/<?=$video->getFilePath();?>" alt="imagem não disponível" style="width: 75%"/>
                </a>
                <?php else:?>
                <iframe width="100%" height="72%" src="<?= $video->url ?>"
                    title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
                <?php endif;?>
                <div class="descricao-video">
                    <img src="/img/logo.png" alt="<?= $video->title ?>">
                    <h3><?= $video->title?></h3>
                    <div class="acoes-video">
                        <a href="/editar-video?id=<?=$video->id; ?>">Editar</a>
                        <a href="/remover-video?id=<?=$video->id; ?>">Excluir</a>
                        <a href="/remover-capa?id=<?=$video->id; ?>">Remover capa</a>
                    </div>
                </div>
            </li>
    <?php endif;?>
    <?php endforeach; ?>
</ul>
<?php require_once 'fim-html.php';