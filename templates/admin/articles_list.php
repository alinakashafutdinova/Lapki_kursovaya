<?php include __DIR__ . '/../header.php'; ?>
<?php
$notices = [
    'added'   => '✅ Статья добавлена.',
    'updated' => '✅ Изменения сохранены.',
    'deleted' => '🗑️ Статья удалена.',
];
?>

<div class="container admin-layout">
    <?php include __DIR__ . '/_sidebar.php'; ?>

    <div class="admin-main">
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:14px;">
            <div>
                <h1>Статьи</h1>
                <p style="color:var(--ink-soft);">Всего статей: <?= count($articles) ?>. Добавление, редактирование и удаление.</p>
            </div>
            <a href="/admin/articles/add" class="btn btn-primary">+ Добавить статью</a>
        </div>

        <?php if (!empty($notice) && isset($notices[$notice])): ?>
            <div class="alert alert-success" style="margin-top:18px;"><?= $notices[$notice] ?></div>
        <?php endif; ?>

        <?php if (empty($articles)): ?>
            <div class="empty-state"><div class="big">📝</div>Статей пока нет. Добавьте первую!</div>
        <?php else: ?>
            <table class="data-table" style="margin-top:18px;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Заголовок</th>
                        <th>Дата</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($articles as $article): ?>
                        <tr>
                            <td><?= $article->getId() ?></td>
                            <td><strong><?= htmlspecialchars($article->getName()) ?></strong></td>
                            <td><?= htmlspecialchars(date('d.m.Y', strtotime($article->getCreatedAt()))) ?></td>
                            <td>
                                <div class="table-actions">
                                    <a href="/articles/<?= $article->getId() ?>" class="btn btn-ghost btn-sm" target="_blank" title="Открыть на сайте">👁</a>
                                    <a href="/admin/articles/edit/<?= $article->getId() ?>" class="btn btn-ghost btn-sm" title="Редактировать">✏️</a>
                                    <form action="/admin/articles/delete/<?= $article->getId() ?>" method="POST" onsubmit="return confirm('Удалить статью «<?= htmlspecialchars($article->getName()) ?>»?');" style="display:inline;">
                                        <button type="submit" class="btn btn-danger btn-sm" title="Удалить">🗑️</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
