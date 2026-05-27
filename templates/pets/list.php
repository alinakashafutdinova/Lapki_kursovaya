<?php include __DIR__ . '/../header.php'; ?>

<div class="container">
    <div class="page-head">
        <span class="eyebrow">Каталог</span>
        <h1>Наши питомцы</h1>
        <p>Выбери друга по душе. Нажми на карточку, чтобы узнать историю каждого хвостика.</p>
    </div>

    <div class="filter-bar">
        <a href="/pets"             class="<?= $species === 'all' ? 'active' : '' ?>">Все</a>
        <a href="/pets?species=cat" class="<?= $species === 'cat' ? 'active' : '' ?>">🐱 Кошки</a>
        <a href="/pets?species=dog" class="<?= $species === 'dog' ? 'active' : '' ?>">🐶 Собаки</a>
        <a href="/pets?species=other" class="<?= $species === 'other' ? 'active' : '' ?>">🐰 Другие</a>
    </div>
</div>

<div class="container" style="padding-bottom:64px;">
    <?php if (empty($pets)): ?>
        <div class="empty-state"><div class="big">🐾</div>В этой категории пока никого нет.</div>
    <?php else: ?>
        <div class="pets-grid">
            <?php foreach ($pets as $pet): ?>
                <article class="pet-card">
                    <div class="pet-photo">
                        <span class="emoji-fallback"><?= $pet->getPhotoEmoji() ?></span>
                        <img src="<?= htmlspecialchars($pet->getImageUrl()) ?>" alt="<?= htmlspecialchars($pet->getName()) ?>" loading="lazy" onerror="this.closest('.pet-photo').classList.add('img-failed'); this.remove();">
                        <span class="badge badge-<?= $pet->getStatus() ?>"><?= $pet->getStatusLabel() ?></span>
                    </div>
                    <div class="pet-body">
                        <h3><?= htmlspecialchars($pet->getName()) ?></h3>
                        <div class="pet-meta"><?= $pet->getSpeciesLabel() ?> · <?= $pet->getGenderLabel() ?> · <?= $pet->getAgeLabel() ?></div>
                        <div class="pet-meta"><?= htmlspecialchars($pet->getBreed()) ?></div>
                        <a href="/pets/<?= $pet->getId() ?>" class="btn btn-ghost btn-sm">Познакомиться</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
