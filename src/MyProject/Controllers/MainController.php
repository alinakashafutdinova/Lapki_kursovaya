<?php

namespace MyProject\Controllers;

use MyProject\Models\Pets\Pet;
use MyProject\Models\Articles\Article;

class MainController extends AbstractController
{
    /** Главная страница: герой-блок, свежие питомцы, последние статьи. */
    public function main(): void
    {
        $pets = Pet::findAll();
        // показываем до 6 питомцев, ищущих дом
        $available = array_filter($pets, function (Pet $p) {
            return $p->getStatus() === 'available';
        });
        $featuredPets = array_slice(array_values($available), 0, 6);

        $articles = Article::findAll();
        $latestArticles = array_slice($articles, 0, 3);

        $stats = [
            'total'     => count($pets),
            'available' => count($available),
            'adopted'   => count(array_filter($pets, function (Pet $p) {
                return $p->getStatus() === 'adopted';
            })),
        ];

        $this->render('main/main.php', [
            'title'          => 'Лапки — приют для животных',
            'featuredPets'   => $featuredPets,
            'latestArticles' => $latestArticles,
            'stats'          => $stats,
        ]);
    }

    // ДЗ3 (роутинг): экшн sayHello — «Привет, $name»
    public function sayHello(string $name): void
    {
        // ДЗ4: для этой страницы задаём собственный title
        $this->render('main/hello.php', [
            'name'  => $name,
            'title' => 'Страница приветствия',
        ]);
    }

    // ДЗ3 (роутинг): новый экшн sayBye — «Пока, $name»
    public function sayBye(string $name): void
    {
        echo 'Пока, ' . htmlspecialchars($name);
    }

    /**
     * Лаба 1: демонстрация функции get_headers().
     * Выводит HTTP-заголовки ответа для указанного URL.
     */
    public function headers(): void
    {
        $defaultUrl = 'https://mospolytech.ru';
        $url = isset($_GET['url']) && trim($_GET['url']) !== '' ? trim($_GET['url']) : $defaultUrl;

        $headers = @get_headers($url, 1);

        if ($headers === false) {
            $output = "Не удалось получить заголовки с адреса: {$url}\n"
                . "Проверьте корректность URL и доступность ресурса.";
        } else {
            $output = "URL: {$url}\n" . str_repeat('—', 50) . "\n\n";
            foreach ($headers as $key => $value) {
                if (is_array($value)) {
                    $value = implode(', ', $value);
                }
                $output .= is_int($key) ? $value . "\n" : $key . ': ' . $value . "\n";
            }
        }

        $this->render('main/headers.php', [
            'title'  => 'HTTP-заголовки (get_headers)',
            'url'    => $url,
            'output' => $output,
        ]);
    }
}
