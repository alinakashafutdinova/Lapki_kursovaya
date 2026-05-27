<?php

// Сессию стартуем в самом начале, до любого вывода —
// это гарантирует надёжное сохранение авторизации между запросами.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    spl_autoload_register(function (string $className) {
        $className = str_replace('\\', '/', $className);
        require_once __DIR__ . '/src/' . $className . '.php';
    });

    $route = $_GET['route'] ?? '';
    $routes = require __DIR__ . '/src/routes.php';

    $isRouteFound = false;
    foreach ($routes as $pattern => $controllerAndAction) {
        preg_match($pattern, $route, $matches);
        if (!empty($matches)) {
            $isRouteFound = true;
            break;
        }
    }

    if (!$isRouteFound) {
        throw new \MyProject\Exceptions\NotFoundException();
    }

    unset($matches[0]);

    $controllerName = $controllerAndAction[0];
    $actionName = $controllerAndAction[1];

    $controller = new $controllerName();
    $controller->$actionName(...$matches);

} catch (\MyProject\Exceptions\NotFoundException $e) {
    $view = new \MyProject\View\View(__DIR__ . '/templates');
    $view->renderHtml('errors/404.php', ['title' => 'Страница не найдена', 'currentUser' => null], 404);
} catch (\MyProject\Exceptions\DbException $e) {
    $view = new \MyProject\View\View(__DIR__ . '/templates');
    $view->renderHtml('errors/500.php', ['title' => 'Ошибка сервера', 'currentUser' => null, 'error' => $e->getMessage()], 500);
}
