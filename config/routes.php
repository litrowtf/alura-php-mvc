<?php

declare(strict_types=1);

use Alura\Mvc\Controller\{JsonVideoListController,
    LoginController,
    LoginFormController,
    NewJsonVideoController,
    VideoCreateController,
    VideoEditController,
    VideoFormController,
    VideoListController,
    VideoRemoveController,
    LogoutController};

return [
    'GET|/' => VideoListController::class,
    'GET|/novo-video' => VideoFormController::class,
    'POST|/novo-video' => VideoCreateController::class,
    'GET|/editar-video' => VideoFormController::class,
    'POST|/editar-video' => VideoEditController::class,
    'GET|/remover-capa' => VideoEditController::class,
    'GET|/remover-video' => VideoRemoveController::class,
    'GET|/login' => LoginFormController::class,
    'POST|/login' => LoginController::class,
    'GET|/logout' => LogoutController::class,
    'GET|/videos-json' => JsonVideoListController::class,
    'POST|/videos' => NewJsonVideoController::class,

];
