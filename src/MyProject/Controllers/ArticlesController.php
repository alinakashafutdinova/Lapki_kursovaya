<?php

namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;
use MyProject\Exceptions\NotFoundException;

class ArticlesController extends AbstractController
{
    /** Список статей-гайдов. */
    public function list(): void
    {
        $this->render('articles/list.php', [
            'title'    => 'Статьи и советы — Лапки',
            'articles' => Article::findAll(),
        ]);
    }

    /**
     * Детальная страница статьи.
     * ДЗ5: после получения статьи делаем дополнительный запрос
     * за автором из таблицы users и выводим его nickname.
     */
    public function show(int $articleId): void
    {
        $article = Article::getById($articleId);
        if ($article === null) {
            throw new NotFoundException('Статья не найдена');
        }

        // ДЗ5: получаем автора статьи
        $author = User::getById($article->getAuthorId());

        // ДЗ4: title статьи задаётся динамически
        $this->render('articles/show.php', [
            'title'   => $article->getName(),
            'article' => $article,
            'author'  => $author,
        ]);
    }
}
