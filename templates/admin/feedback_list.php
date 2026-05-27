<?php include __DIR__ . '/../header.php'; ?>

<div class="container admin-layout">
    <?php include __DIR__ . '/_sidebar.php'; ?>

    <div class="admin-main">
        <h1>Обращения</h1>
        <p style="color:var(--ink-soft);">Заявки и сообщения, отправленные через форму обратной связи.</p>

        <?php if (empty($messages)): ?>
            <div class="empty-state"><div class="big">📭</div>Обращений пока нет.</div>
        <?php else: ?>
            <table class="data-table" style="margin-top:18px;">
                <thead>
                    <tr><th>#</th><th>Имя</th><th>E-mail</th><th>Тип</th><th>Сообщение</th><th>Ответ</th><th>Дата</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $m): ?>
                        <tr>
                            <td><?= $m->getId() ?></td>
                            <td><strong><?= htmlspecialchars($m->getName()) ?></strong></td>
                            <td><?= htmlspecialchars($m->getEmail()) ?></td>
                            <td><span class="badge badge-reserved"><?= htmlspecialchars($m->getTypeLabel()) ?></span></td>
                            <td style="max-width:320px;"><?= htmlspecialchars($m->getMessage()) ?></td>
                            <td><?= htmlspecialchars($m->getReplyMethods()) ?></td>
                            <td><?= htmlspecialchars(date('d.m.Y H:i', strtotime($m->getCreatedAt()))) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
