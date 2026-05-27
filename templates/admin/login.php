<?php include __DIR__ . '/../header.php'; ?>

<div class="container">
    <div class="form-wrap" style="margin-top:50px; margin-bottom:60px;">
        <div class="card-panel">
            <div style="text-align:center; margin-bottom:24px;">
                <div style="font-size:3rem;">🔐</div>
                <h1 style="font-size:1.8rem; margin-top:8px;">Вход для сотрудников</h1>
                <p style="color:var(--ink-soft);">Панель управления приютом</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form action="/admin/login-submit" method="POST">
                <div class="field">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" placeholder="admin@lapki.ru" required>
                </div>
                <div class="field">
                    <label for="password">Пароль</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">Войти</button>
            </form>

            <div class="alert alert-info" style="margin-top:20px; margin-bottom:0;">
                <strong>Демо-доступ:</strong> admin@lapki.ru / admin123
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
