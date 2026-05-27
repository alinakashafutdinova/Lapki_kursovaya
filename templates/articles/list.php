<?php include __DIR__ . '/../header.php'; ?>

<div class="container">
    <div class="page-head">
        <span class="eyebrow">Блог приюта</span>
        <h1>Статьи и советы</h1>
        <p>Всё о том, как заботиться о питомце, помочь ему адаптироваться и стать счастливее вместе.</p>
    </div>
</div>

<div class="container" style="padding-bottom:64px;">
    <?php if (empty($articles)): ?>
        <div class="empty-state"><div class="big">📝</div>Статей пока нет.</div>
    <?php else: ?>
        <div class="articles-grid">
            <?php foreach ($articles as $article): ?>
                <article class="article-card">
                    <span class="tag">Совет</span>
                    <h3><a href="/articles/<?= $article->getId() ?>"><?= htmlspecialchars($article->getName()) ?></a></h3>
                    <p><?= htmlspecialchars($article->getExcerpt(160)) ?></p>
                    <div class="meta">📅 <?= htmlspecialchars(date('d.m.Y', strtotime($article->getCreatedAt()))) ?></div>
                    <a href="/articles/<?= $article->getId() ?>" class="btn btn-ghost btn-sm">Читать статью →</a>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
