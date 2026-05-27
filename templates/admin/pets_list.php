<?php include __DIR__ . '/../header.php'; ?>
<?php
$notices = [
    'added'   => '✅ Питомец добавлен.',
    'updated' => '✅ Изменения сохранены.',
    'deleted' => '🗑️ Запись удалена.',
];
// хелпер для ссылок сортировки с сохранением страницы
$sortLink = function (string $col) use ($sort, $page) {
    $cls = $sort === $col ? 'sorted' : '';
    return '<a class="' . $cls . '" href="/admin/pets?sort=' . $col . '&page=' . $page . '">';
};
?>

<div class="container admin-layout">
    <?php include __DIR__ . '/_sidebar.php'; ?>

    <div class="admin-main">
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:14px;">
            <div>
                <h1>Питомцы</h1>
                <p style="color:var(--ink-soft);">Всего записей: <?= (int)$total ?>. Просмотр, добавление, редактирование и удаление.</p>
            </div>
            <a href="/admin/pets/add" class="btn btn-primary">+ Добавить</a>
        </div>

        <?php if (!empty($notice) && isset($notices[$notice])): ?>
            <div class="alert alert-success" style="margin-top:18px;"><?= $notices[$notice] ?></div>
        <?php endif; ?>

        <p style="margin:18px 0 10px; color:var(--ink-soft); font-size:.9rem;">Сортировка:
            <?= $sortLink('id') ?>по дате добавления</a> ·
            <?= $sortLink('name') ?>по кличке</a> ·
            <?= $sortLink('age_months') ?>по возрасту</a> ·
            <?= $sortLink('status') ?>по статусу</a>
        </p>

        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th><?= $sortLink('name') ?>Кличка</a></th>
                    <th>Вид</th>
                    <th>Пол</th>
                    <th><?= $sortLink('age_months') ?>Возраст</a></th>
                    <th>Вес</th>
                    <th><?= $sortLink('status') ?>Статус</a></th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pets)): ?>
                    <tr><td colspan="8" style="text-align:center; color:var(--muted); padding:30px;">Записей нет</td></tr>
                <?php else: ?>
                    <?php foreach ($pets as $pet): ?>
                        <tr>
                            <td><?= $pet->getId() ?></td>
                            <td><span class="adm-thumb"><img src="<?= htmlspecialchars($pet->getImageUrl()) ?>" alt="" loading="lazy" onerror="this.replaceWith(document.createTextNode('<?= $pet->getPhotoEmoji() ?>'))"></span> <strong><?= htmlspecialchars($pet->getName()) ?></strong></td>
                            <td><?= $pet->getSpeciesLabel() ?></td>
                            <td><?= $pet->getGenderLabel() ?></td>
                            <td><?= $pet->getAgeLabel() ?></td>
                            <td><?= number_format($pet->getWeightKg(), 1, ',', ' ') ?> кг</td>
                            <td><span class="badge badge-<?= $pet->getStatus() ?>"><?= $pet->getStatusLabel() ?></span></td>
                            <td>
                                <div class="table-actions">
                                    <a href="/admin/pets/edit/<?= $pet->getId() ?>" class="btn btn-ghost btn-sm">✏️</a>
                                    <form action="/admin/pets/delete/<?= $pet->getId() ?>" method="POST" onsubmit="return confirm('Удалить запись о питомце <?= htmlspecialchars($pet->getName()) ?>?');" style="display:inline;">
                                        <button type="submit" class="btn btn-danger btn-sm">🗑️</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                    <?php if ($p === $page): ?>
                        <span class="current"><?= $p ?></span>
                    <?php else: ?>
                        <a href="/admin/pets?sort=<?= htmlspecialchars($sort) ?>&page=<?= $p ?>"><?= $p ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
