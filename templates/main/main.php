<?php include __DIR__ . '/../header.php'; ?>

<section class="hero">
    <div class="container hero-grid">
        <div class="reveal">
            <span class="eyebrow">🏠 Приют для животных</span>
            <h1>Подари дом тому, кто <span class="accent">очень ждёт</span></h1>
            <p class="lead">Сотни пушистых сердец мечтают о семье. Познакомься с нашими питомцами, рассчитай заботу о них и стань тем самым человеком, которого они ищут.</p>
            <div class="hero-actions">
                <a href="/pets" class="btn btn-primary">Найти друга 🐾</a>
                <a href="/feedback" class="btn btn-ghost">Стать волонтёром</a>
            </div>
            <div class="stat-row">
                <div class="stat"><b><?= (int)$stats['total'] ?></b><span>питомцев у нас</span></div>
                <div class="stat"><b><?= (int)$stats['available'] ?></b><span>ищут дом сейчас</span></div>
                <div class="stat"><b><?= (int)$stats['adopted'] ?></b><span>обрели семью</span></div>
            </div>
        </div>
        <div class="hero-visual reveal">
            <div class="big-emoji">🐶</div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <div>
                <h2>Они ищут дом</h2>
                <p>Эти ребята уже готовы переехать к тебе</p>
            </div>
            <a href="/pets" class="btn btn-ghost btn-sm">Все питомцы →</a>
        </div>
        <div class="pets-grid">
            <?php foreach ($featuredPets as $pet): ?>
                <article class="pet-card">
                    <div class="pet-photo">
                        <span class="emoji-fallback"><?= $pet->getPhotoEmoji() ?></span>
                        <img src="<?= htmlspecialchars($pet->getImageUrl()) ?>" alt="<?= htmlspecialchars($pet->getName()) ?>" loading="lazy" onerror="this.closest('.pet-photo').classList.add('img-failed'); this.remove();">
                        <span class="badge badge-<?= $pet->getStatus() ?>"><?= $pet->getStatusLabel() ?></span>
                    </div>
                    <div class="pet-body">
                        <h3><?= htmlspecialchars($pet->getName()) ?></h3>
                        <div class="pet-meta"><?= $pet->getSpeciesLabel() ?> · <?= $pet->getGenderLabel() ?> · <?= $pet->getAgeLabel() ?></div>
                        <a href="/pets/<?= $pet->getId() ?>" class="btn btn-ghost btn-sm">Познакомиться</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section alt">
    <div class="container">
        <div class="section-head">
            <div>
                <h2>Полезные статьи</h2>
                <p>Советы по уходу от наших волонтёров</p>
            </div>
            <a href="/articles" class="btn btn-ghost btn-sm">Все статьи →</a>
        </div>
        <div class="articles-grid">
            <?php foreach ($latestArticles as $article): ?>
                <article class="article-card">
                    <span class="tag">Совет</span>
                    <h3><a href="/articles/<?= $article->getId() ?>"><?= htmlspecialchars($article->getName()) ?></a></h3>
                    <p><?= htmlspecialchars($article->getExcerpt(120)) ?></p>
                    <a href="/articles/<?= $article->getId() ?>" class="btn btn-ghost btn-sm">Читать →</a>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="cta">
            <h2>Не готов забрать питомца? Помоги иначе!</h2>
            <p>Стань волонтёром, расскажи о нас друзьям или задай вопрос — каждая помощь важна.</p>
            <a href="/feedback" class="btn btn-primary">Связаться с приютом</a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../footer.php'; ?>
