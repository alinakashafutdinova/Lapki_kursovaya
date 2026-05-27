<?php include __DIR__ . '/../header.php'; ?>
<?php
/** @var \MyProject\Models\Pets\Pet|null $pet */
$old = $old ?? [];
// значение поля: из старого ввода (после ошибки), либо из объекта, либо дефолт
$val = function (string $key, $default = '') use ($pet, $old) {
    if (array_key_exists($key, $old)) return $old[$key];
    if ($pet === null) return $default;
    $map = [
        'name' => $pet->getName(), 'species' => $pet->getSpecies(), 'breed' => $pet->getBreed(),
        'gender' => $pet->getGender(), 'age_months' => $pet->getAgeMonths(), 'weight_kg' => $pet->getWeightKg(),
        'color' => $pet->getColor(), 'activity' => $pet->getActivity(),
        'description' => $pet->getDescription(), 'photo_url' => $pet->getPhotoUrl(), 'status' => $pet->getStatus(),
    ];
    return $map[$key] ?? $default;
};
$action = $mode === 'edit' ? '/admin/pets/update/' . $pet->getId() : '/admin/pets/store';
$sel = function ($a, $b) { return (string)$a === (string)$b ? 'selected' : ''; };
?>

<div class="container admin-layout">
    <?php include __DIR__ . '/_sidebar.php'; ?>

    <div class="admin-main">
        <div class="breadcrumb"><a href="/admin/pets">← К списку питомцев</a></div>
        <h1><?= $mode === 'edit' ? 'Редактировать питомца' : 'Добавить питомца' ?></h1>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error" style="margin-top:16px;">
                Исправьте ошибки:
                <ul><?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul>
            </div>
        <?php endif; ?>

        <div class="card-panel" style="margin-top:18px;">
            <form action="<?= $action ?>" method="POST">
                <div class="row-2">
                    <div class="field">
                        <label for="name">Кличка *</label>
                        <input type="text" id="name" name="name" value="<?= htmlspecialchars($val('name')) ?>" required>
                    </div>
                    <div class="field">
                        <label for="photo_url">Фото питомца</label>
                        <input type="text" id="photo_url" name="photo_url" value="<?= htmlspecialchars($val('photo_url', '')) ?>" placeholder="https://… или /uploads/cat.jpg">
                        <div class="hint">Ссылка на фото (URL) или путь к файлу. Можно оставить пустым — тогда подберётся фото по виду животного. Допустим и эмодзи (🐱).</div>
                    </div>
                </div>

                <div class="row-2">
                    <div class="field">
                        <label for="species">Вид *</label>
                        <select id="species" name="species">
                            <option value="cat"   <?= $sel($val('species','cat'),'cat') ?>>Кошка</option>
                            <option value="dog"   <?= $sel($val('species'),'dog') ?>>Собака</option>
                            <option value="other" <?= $sel($val('species'),'other') ?>>Другое</option>
                        </select>
                    </div>
                    <div class="field">
                        <label for="breed">Порода</label>
                        <input type="text" id="breed" name="breed" value="<?= htmlspecialchars($val('breed')) ?>">
                    </div>
                </div>

                <div class="row-2">
                    <div class="field">
                        <label for="gender">Пол *</label>
                        <select id="gender" name="gender">
                            <option value="male"   <?= $sel($val('gender','male'),'male') ?>>Мальчик</option>
                            <option value="female" <?= $sel($val('gender'),'female') ?>>Девочка</option>
                        </select>
                    </div>
                    <div class="field">
                        <label for="color">Окрас</label>
                        <input type="text" id="color" name="color" value="<?= htmlspecialchars($val('color')) ?>">
                    </div>
                </div>

                <div class="row-2">
                    <div class="field">
                        <label for="age_months">Возраст (месяцев)</label>
                        <input type="number" id="age_months" name="age_months" min="0" value="<?= htmlspecialchars($val('age_months', 0)) ?>">
                    </div>
                    <div class="field">
                        <label for="weight_kg">Вес (кг)</label>
                        <input type="number" id="weight_kg" name="weight_kg" step="0.1" min="0" value="<?= htmlspecialchars($val('weight_kg', 0)) ?>">
                    </div>
                </div>

                <div class="row-2">
                    <div class="field">
                        <label for="activity">Активность</label>
                        <select id="activity" name="activity">
                            <option value="low"    <?= $sel($val('activity'),'low') ?>>Низкая</option>
                            <option value="normal" <?= $sel($val('activity','normal'),'normal') ?>>Средняя</option>
                            <option value="high"   <?= $sel($val('activity'),'high') ?>>Высокая</option>
                        </select>
                    </div>
                    <div class="field">
                        <label for="status">Статус</label>
                        <select id="status" name="status">
                            <option value="available" <?= $sel($val('status','available'),'available') ?>>Ищет дом</option>
                            <option value="reserved"  <?= $sel($val('status'),'reserved') ?>>Забронирован</option>
                            <option value="adopted"   <?= $sel($val('status'),'adopted') ?>>Дома</option>
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label for="description">Описание *</label>
                    <textarea id="description" name="description" required><?= htmlspecialchars($val('description')) ?></textarea>
                </div>

                <div style="display:flex; gap:12px;">
                    <button type="submit" class="btn btn-primary"><?= $mode === 'edit' ? 'Сохранить' : 'Добавить' ?></button>
                    <a href="/admin/pets" class="btn btn-ghost">Отмена</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
