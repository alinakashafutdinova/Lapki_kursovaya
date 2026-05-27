<?php include __DIR__ . '/../header.php'; ?>
<?php
$old = $old ?? [];
$val = function (string $k, string $def = '') use ($old, $article) {
    if (isset($old[$k])) return $old[$k];
    if ($article !== null) {
        if ($k === 'name') return $article->getName();
        if ($k === 'text') return $article->getText();
    }
    return $def;
};
$isEdit = ($mode === 'edit');
$action = $isEdit ? '/admin/articles/update/' . $article->getId() : '/admin/articles/store';
?>

<div class="container admin-layout">
    <?php include __DIR__ . '/_sidebar.php'; ?>

    <div class="admin-main">
        <div class="breadcrumb"><a href="/admin/articles">← К списку статей</a></div>
        <h1><?= $isEdit ? 'Редактировать статью' : 'Добавить статью' ?></h1>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error" style="margin-top:14px;">
                Проверьте поля:
                <ul><?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul>
            </div>
        <?php endif; ?>

        <div class="card-panel" style="margin-top:16px; max-width:760px;">
            <form action="<?= $action ?>" method="POST">
                <div class="field">
                    <label for="name">Заголовок статьи</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($val('name')) ?>" placeholder="Например: Как приучить котёнка к лотку" required>
                </div>
                <div class="field">
                    <label for="text">Текст статьи</label>
                    <textarea id="text" name="text" style="min-height:280px;" placeholder="Полный текст статьи. Абзацы разделяйте пустой строкой." required><?= htmlspecialchars($val('text')) ?></textarea>
                    <div class="hint">Абзацы разделяйте переносом строки — они отобразятся на сайте отдельными абзацами.</div>
                </div>
                <div style="display:flex; gap:12px;">
                    <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Сохранить изменения' : 'Опубликовать статью' ?></button>
                    <a href="/admin/articles" class="btn btn-ghost">Отмена</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
