<?php include __DIR__ . '/../header.php'; ?>

<div class="container admin-layout">
    <?php include __DIR__ . '/_sidebar.php'; ?>

    <div class="admin-main">
        <h1>Панель управления</h1>
        <p style="color:var(--ink-soft);">Добро пожаловать! Здесь вы управляете приютом «Лапки».</p>

        <div class="dash-cards">
            <div class="dash-card"><b><?= (int)$stats['pets'] ?></b><span>питомцев всего</span></div>
            <div class="dash-card"><b><?= (int)$stats['available'] ?></b><span>ищут дом</span></div>
            <div class="dash-card"><b><?= (int)$stats['feedback'] ?></b><span>обращений</span></div>
        </div>

        <div style="display:flex; gap:14px; flex-wrap:wrap;">
            <a href="/admin/pets/add" class="btn btn-primary">+ Добавить питомца</a>
            <a href="/admin/pets" class="btn btn-ghost">Управление питомцами</a>
            <a href="/admin/articles" class="btn btn-ghost">Управление статьями</a>
            <a href="/admin/feedback" class="btn btn-ghost">Посмотреть обращения</a>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
