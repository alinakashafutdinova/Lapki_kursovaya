<?php include __DIR__ . '/../header.php'; ?>

<div class="container detail">
    <div class="card-panel" style="text-align:center; max-width:560px; margin:40px auto;">
        <div style="font-size:4rem;">👋</div>
        <h1 style="font-size:2.4rem; margin:14px 0;">Привет, <?= htmlspecialchars($name) ?>!</h1>
        <p style="color:var(--ink-soft);">Это демонстрационная страница роутинга. Заголовок вкладки браузера — «Страница приветствия» (задаётся через переменную шаблона).</p>
        <div style="margin-top:22px;"><a href="/" class="btn btn-primary">На главную 🐾</a></div>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
