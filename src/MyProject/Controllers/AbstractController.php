<?php

namespace MyProject\Controllers;

use MyProject\Services\Auth;
use MyProject\View\View;

abstract class AbstractController
{
    /** @var View */
    protected $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    /**
     * Рендер с автоматической передачей текущего пользователя
     * (нужно для меню: показывать вход или панель админа).
     */
    protected function render(string $template, array $vars = [], int $code = 200): void
    {
        $vars['currentUser'] = Auth::getCurrentUser();
        $this->view->renderHtml($template, $vars, $code);
    }

    /** Защита админских страниц: пускаем только администратора. */
    protected function requireAdmin(): void
    {
        if (!Auth::isAdmin()) {
            header('Location: /admin/login');
            exit;
        }
    }

    /** Безопасный редирект. */
    protected function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }
}
