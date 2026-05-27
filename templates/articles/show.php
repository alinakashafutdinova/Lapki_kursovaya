<?php include __DIR__ . '/../header.php'; ?>

<div class="container detail">
    <div class="breadcrumb"><a href="/articles">← Все статьи</a></div>
    <div class="article-head">
        <span class="tag" style="color:var(--terra-dk); font-weight:700;">СОВЕТ</span>
        <h1><?= htmlspecialchars($article->getName()) ?></h1>
        <div class="byline">
            <?php if ($author !== null): ?>
                <span class="avatar"><?= htmlspecialchars(mb_substr($author->getNickname(), 0, 1)) ?></span>
                <span>Автор: <strong><?= htmlspecialchars($author->getNickname()) ?></strong></span>
            <?php endif; ?>
            <span>· 📅 <?= htmlspecialchars(date('d.m.Y', strtotime($article->getCreatedAt()))) ?></span>
        </div>
    </div>

    <div class="prose">
        <?php foreach (preg_split('/\n+/', $article->getText()) as $para): ?>
            <?php $para = trim($para); if ($para !== ''): ?>
                <p><?= htmlspecialchars($para) ?></p>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <div class="prose" style="margin-top:30px;">
        <a href="/calculator" class="btn btn-primary">Открыть калькулятор корма 🍽️</a>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
