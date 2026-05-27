<?php include __DIR__ . '/../header.php'; ?>

<div class="container">
    <div class="page-head">
        <span class="eyebrow">Сервисная информация</span>
        <h1>HTTP-заголовки</h1>
        <p>Демонстрация работы функции <code>get_headers()</code> — вывод заголовков HTTP-ответа для указанного URL.</p>
    </div>
</div>

<div class="container" style="padding-bottom:64px;">
    <div class="card-panel" style="margin-bottom:22px;">
        <form action="/headers" method="GET">
            <div class="field" style="margin-bottom:0;">
                <label for="url">URL для запроса</label>
                <div style="display:flex; gap:12px; flex-wrap:wrap;">
                    <input type="url" id="url" name="url" value="<?= htmlspecialchars($url) ?>" placeholder="https://example.com" style="flex:1; min-width:220px;">
                    <button type="submit" class="btn btn-dark">Запросить</button>
                </div>
            </div>
        </form>
    </div>

    <textarea class="code-area" readonly><?= htmlspecialchars($output) ?></textarea>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
