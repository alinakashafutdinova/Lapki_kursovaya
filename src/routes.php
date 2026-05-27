<?php

use MyProject\Controllers\MainController;
use MyProject\Controllers\PetsController;
use MyProject\Controllers\ArticlesController;
use MyProject\Controllers\FeedbackController;
use MyProject\Controllers\CalculatorController;
use MyProject\Controllers\AdminController;

return [
    // ----------------------- Публичная часть -----------------------
    '~^pets$~'                    => [PetsController::class, 'list'],
    '~^pets/(\d+)$~'              => [PetsController::class, 'show'],

    '~^articles$~'                => [ArticlesController::class, 'list'],
    '~^articles/(\d+)$~'          => [ArticlesController::class, 'show'],

    '~^calculator$~'              => [CalculatorController::class, 'feed'],

    '~^feedback$~'                => [FeedbackController::class, 'form'],
    '~^feedback/submit$~'         => [FeedbackController::class, 'submit'],

    '~^headers$~'                 => [MainController::class, 'headers'],

    // Демонстрация роутинга (ДЗ3-4)
    '~^hello/(.+)$~'              => [MainController::class, 'sayHello'],
    '~^bye/(.+)$~'                => [MainController::class, 'sayBye'],

    // ----------------------- Админ-панель --------------------------
    '~^admin/login$~'             => [AdminController::class, 'loginForm'],
    '~^admin/login-submit$~'      => [AdminController::class, 'login'],
    '~^admin/logout$~'            => [AdminController::class, 'logout'],

    '~^admin/pets/add$~'          => [AdminController::class, 'petAddForm'],
    '~^admin/pets/store$~'        => [AdminController::class, 'petAdd'],
    '~^admin/pets/edit/(\d+)$~'   => [AdminController::class, 'petEditForm'],
    '~^admin/pets/update/(\d+)$~' => [AdminController::class, 'petEdit'],
    '~^admin/pets/delete/(\d+)$~' => [AdminController::class, 'petDelete'],
    '~^admin/pets$~'              => [AdminController::class, 'petsList'],

    '~^admin/articles/add$~'          => [AdminController::class, 'articleAddForm'],
    '~^admin/articles/store$~'        => [AdminController::class, 'articleAdd'],
    '~^admin/articles/edit/(\d+)$~'   => [AdminController::class, 'articleEditForm'],
    '~^admin/articles/update/(\d+)$~' => [AdminController::class, 'articleEdit'],
    '~^admin/articles/delete/(\d+)$~' => [AdminController::class, 'articleDelete'],
    '~^admin/articles$~'              => [AdminController::class, 'articlesList'],

    '~^admin/feedback$~'          => [AdminController::class, 'feedbackList'],
    '~^admin$~'                   => [AdminController::class, 'dashboard'],

    // ----------------------- Главная -------------------------------
    '~^$~'                        => [MainController::class, 'main'],
];
