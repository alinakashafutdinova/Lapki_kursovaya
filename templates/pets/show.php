<?php include __DIR__ . '/../header.php'; ?>

<div class="container detail">
    <div class="breadcrumb"><a href="/pets">← Все питомцы</a></div>
    <div class="detail-grid">
        <div class="detail-photo">
            <span class="emoji-fallback"><?= $pet->getPhotoEmoji() ?></span>
            <img src="<?= htmlspecialchars($pet->getImageUrl()) ?>" alt="<?= htmlspecialchars($pet->getName()) ?>" onerror="this.closest('.detail-photo').classList.add('img-failed'); this.remove();">
        </div>
        <div>
            <span class="badge badge-<?= $pet->getStatus() ?>"><?= $pet->getStatusLabel() ?></span>
            <h1><?= htmlspecialchars($pet->getName()) ?></h1>
            <p style="color:var(--ink-soft); font-size:1.1rem;"><?= htmlspecialchars($pet->getDescription()) ?></p>

            <ul class="specs">
                <li><span>Вид</span><span><?= $pet->getSpeciesLabel() ?></span></li>
                <li><span>Порода</span><span><?= htmlspecialchars($pet->getBreed()) ?: '—' ?></span></li>
                <li><span>Пол</span><span><?= $pet->getGenderLabel() ?></span></li>
                <li><span>Возраст</span><span><?= $pet->getAgeLabel() ?></span></li>
                <li><span>Вес</span><span><?= number_format($pet->getWeightKg(), 1, ',', ' ') ?> кг</span></li>
                <li><span>Окрас</span><span><?= htmlspecialchars($pet->getColor()) ?: '—' ?></span></li>
                <li><span>Активность</span><span><?= $pet->getActivityLabel() ?></span></li>
            </ul>

            <div class="hero-actions">
                <?php if ($pet->getStatus() === 'available'): ?>
                    <a href="/feedback" class="btn btn-primary">Хочу забрать <?= htmlspecialchars($pet->getName()) ?> 🏡</a>
                <?php endif; ?>
                <a href="/calculator?weight=<?= $pet->getWeightKg() ?>&species=<?= $pet->getSpecies() === 'dog' ? 'dog' : 'cat' ?>&activity=<?= $pet->getActivity() ?>" class="btn btn-ghost">Рассчитать корм 🍽️</a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
