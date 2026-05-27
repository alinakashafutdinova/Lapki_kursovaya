<?php include __DIR__ . '/../header.php'; ?>

<div class="container">
    <div class="empty-state" style="padding:90px 20px;">
        <div class="big" style="font-size:5rem;">🙀</div>
        <h1 style="font-size:2.4rem;">Что-то пошло не так</h1>
        <p style="margin:12px 0 24px; color:var(--ink-soft);">Произошла ошибка на сервере. Мы уже разбираемся.</p>
        <?php if (!empty($error)): ?>
            <p style="color:var(--muted); font-size:.85rem;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <a href="/" class="btn btn-primary" style="margin-top:14px;">На главную 🏠</a>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
