<?php include __DIR__ . '/../header.php'; ?>

<div class="container">
    <div class="page-head">
        <span class="eyebrow">Динамический расчёт</span>
        <h1>Калькулятор корма</h1>
        <p>Рассчитайте суточную норму сухого корма для питомца на основе его параметров: вида, веса, возраста и активности.</p>
    </div>
</div>

<div class="container" style="padding-bottom:64px;">
    <div class="calc-grid">
        <!-- Параметры -->
        <div class="card-panel">
            <form action="/calculator" method="GET">
                <div class="field">
                    <label for="species">Вид животного</label>
                    <select id="species" name="species">
                        <option value="cat" <?= $params['species'] === 'cat' ? 'selected' : '' ?>>🐱 Кошка</option>
                        <option value="dog" <?= $params['species'] === 'dog' ? 'selected' : '' ?>>🐶 Собака</option>
                    </select>
                </div>
                <div class="field">
                    <label for="weight">Вес питомца, кг</label>
                    <input type="number" id="weight" name="weight" step="0.1" min="0.1" max="100"
                           placeholder="например, 4.5" value="<?= htmlspecialchars($params['weight']) ?>" required>
                    <div class="hint">Введите текущий вес животного в килограммах.</div>
                </div>
                <div class="field">
                    <label for="age">Возрастная группа</label>
                    <select id="age" name="age">
                        <option value="baby"   <?= $params['age'] === 'baby' ? 'selected' : '' ?>>Малыш (до 1 года)</option>
                        <option value="adult"  <?= $params['age'] === 'adult' ? 'selected' : '' ?>>Взрослый</option>
                        <option value="senior" <?= $params['age'] === 'senior' ? 'selected' : '' ?>>Пожилой (7+ лет)</option>
                    </select>
                </div>
                <div class="field">
                    <label for="activity">Активность</label>
                    <select id="activity" name="activity">
                        <option value="low"    <?= $params['activity'] === 'low' ? 'selected' : '' ?>>Низкая (домосед)</option>
                        <option value="normal" <?= $params['activity'] === 'normal' ? 'selected' : '' ?>>Средняя</option>
                        <option value="high"   <?= $params['activity'] === 'high' ? 'selected' : '' ?>>Высокая (очень активный)</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Рассчитать 🍽️</button>
            </form>
        </div>

        <!-- Результат -->
        <div class="calc-result">
            <?php if ($result !== null): ?>
                <h3>Суточная норма корма</h3>
                <div class="calc-big"><?= (int)$result['grams'] ?> <small>г / день</small></div>
                <div class="calc-stats">
                    <div class="calc-stat"><b><?= (int)$result['kcal'] ?></b><span>ккал в день</span></div>
                    <div class="calc-stat"><b><?= (int)$result['meals'] ?></b><span>кормлений в день</span></div>
                    <div class="calc-stat"><b><?= (int)$result['gramsPerMeal'] ?> г</b><span>за одно кормление</span></div>
                    <div class="calc-stat"><b>≈ <?= round($result['grams'] * 30 / 1000, 1) ?> кг</b><span>в месяц</span></div>
                </div>
                <p style="opacity:.7; font-size:.85rem; margin-top:18px;">* Расчёт ориентировочный. Точную норму уточняйте у ветеринара и на упаковке корма.</p>
            <?php else: ?>
                <div class="calc-empty">
                    <div>
                        <div style="font-size:3rem; margin-bottom:10px;">🐾</div>
                        Заполните параметры слева<br>и нажмите «Рассчитать»
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
