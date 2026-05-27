<?php
/** @var string|null $title */
/** @var \MyProject\Models\Users\User|null $currentUser */
$currentUser = $currentUser ?? null;
$route = $_GET['route'] ?? '';
$is = function (string $prefix) use ($route) {
    return $prefix === '' ? $route === '' : strpos($route, $prefix) === 0;
};
?><!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) : 'Лапки — приют для животных' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Onest:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/styles/styles.css">
</head>
<body>

<header class="site-header">
    <div class="container">
        <a href="/" class="brand"><span class="paw">🐾</span> Лапки</a>
        <nav class="nav">
            <a href="/"          class="<?= $is('') ? 'active' : '' ?>">Главная</a>
            <a href="/pets"      class="<?= $is('pets') ? 'active' : '' ?>">Питомцы</a>
            <a href="/articles"  class="<?= $is('articles') ? 'active' : '' ?>">Статьи</a>
            <a href="/calculator" class="<?= $is('calculator') ? 'active' : '' ?>">Калькулятор</a>
            <a href="/feedback"  class="<?= $is('feedback') ? 'active' : '' ?>">Контакты</a>
            <?php if ($currentUser !== null && $currentUser->isAdmin()): ?>
                <a href="/admin" class="btn-nav">Панель</a>
            <?php else: ?>
                <a href="/admin/login" class="btn-nav">Вход</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<main>
