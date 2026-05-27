<?php

namespace MyProject\View;

class View
{
    /** @var string */
    private $templatesPath;

    public function __construct(string $templatesPath)
    {
        $this->templatesPath = $templatesPath;
    }

    /**
     * Рендерит шаблон с переданными переменными.
     *
     * @param string $templateName Имя файла шаблона
     * @param array  $vars         Переменные, доступные внутри шаблона
     * @param int    $code         HTTP-код ответа (по умолчанию 200)
     */
    public function renderHtml(string $templateName, array $vars = [], int $code = 200): void
    {
        http_response_code($code);
        extract($vars);

        ob_start();
        include $this->templatesPath . '/' . $templateName;
        $buffer = ob_get_contents();
        ob_end_clean();

        echo $buffer;
    }
}
