<?php include __DIR__ . '/../header.php'; ?>
<?php $old = $old ?? []; ?>

<div class="container">
    <div class="page-head">
        <span class="eyebrow">Контакты</span>
        <h1>Связаться с нами</h1>
        <p>Хотите забрать питомца, стать волонтёром или просто задать вопрос? Напишите нам — мы ответим как можно скорее.</p>
    </div>
</div>

<div class="container" style="padding-bottom:64px;">
    <div class="form-wrap">
        <div class="card-panel">
            <?php if (!empty($sent)): ?>
                <div class="alert alert-success">✅ Спасибо! Ваше обращение отправлено. Мы свяжемся с вами в ближайшее время.</div>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    Пожалуйста, исправьте ошибки:
                    <ul>
                        <?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="/feedback/submit" method="POST">
                <div class="field">
                    <label for="name">Имя</label>
                    <input type="text" id="name" name="name" placeholder="Как к вам обращаться?" value="<?= htmlspecialchars($old['name'] ?? '') ?>" required>
                </div>
                <div class="field">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" placeholder="you@example.com" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
                </div>
                <div class="field">
                    <label for="type">Тип обращения</label>
                    <select id="type" name="type" required>
                        <?php
                        $types = ['adopt' => 'Хочу забрать питомца', 'volunteer' => 'Стать волонтёром', 'question' => 'Вопрос', 'gratitude' => 'Благодарность'];
                        $selType = $old['type'] ?? '';
                        ?>
                        <option value="" disabled <?= $selType === '' ? 'selected' : '' ?>>Выберите…</option>
                        <?php foreach ($types as $val => $label): ?>
                            <option value="<?= $val ?>" <?= $selType === $val ? 'selected' : '' ?>><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="field">
                    <label for="message">Текст обращения</label>
                    <textarea id="message" name="message" placeholder="Расскажите подробнее…" required><?= htmlspecialchars($old['message'] ?? '') ?></textarea>
                </div>
                <div class="field">
                    <label>Как вам удобнее получить ответ?</label>
                    <div class="checks">
                        <label class="check"><input type="checkbox" name="reply[]" value="sms"> СМС</label>
                        <label class="check"><input type="checkbox" name="reply[]" value="email"> E-mail</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Отправить обращение 🐾</button>
            </form>
        </div>
        <p style="text-align:center; margin-top:18px; color:var(--muted); font-size:.9rem;">
            Данные отправляются методом POST и сохраняются в базе приюта.
        </p>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
