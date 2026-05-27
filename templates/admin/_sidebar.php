<?php
/** @var \MyProject\Models\Users\User|null $currentUser */
$route = $_GET['route'] ?? '';
$activeAdmin = function (string $p) use ($route) {
    if ($p === 'admin') return $route === 'admin';
    return strpos($route, $p) === 0;
};
?>
<aside class="admin-side">
    <div class="who">👤 <?= htmlspecialchars($currentUser ? $currentUser->getNickname() : 'admin') ?> · администратор</div>
    <a href="/admin"          class="<?= $activeAdmin('admin') ? 'active' : '' ?>">📊 Дашборд</a>
    <a href="/admin/pets"     class="<?= $activeAdmin('admin/pets') ? 'active' : '' ?>">🐾 Питомцы</a>
    <a href="/admin/articles" class="<?= $activeAdmin('admin/articles') ? 'active' : '' ?>">📝 Статьи</a>
    <a href="/admin/feedback" class="<?= $activeAdmin('admin/feedback') ? 'active' : '' ?>">✉️ Обращения</a>
    <a href="/" style="margin-top:14px;">🏠 На сайт</a>
    <a href="/admin/logout" style="color:#c8412c;">🚪 Выйти</a>
</aside>
