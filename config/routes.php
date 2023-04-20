<?php

declare(strict_types=1);

use Alura\Mvc\Controller\{VideoCreateController,
    VideoEditController,
    VideoFormController,
    VideoListController,
    VideoRemoveController};

return [
    'GET|/' => VideoListController::class,
    'GET|/novo-video' => VideoFormController::class,
    'POST|/novo-video' => VideoCreateController::class,
    'GET|/editar-video' => VideoFormController::class,
    'POST|/editar-video' => VideoEditController::class,
    'GET|/remover-video' => VideoRemoveController::class,
];