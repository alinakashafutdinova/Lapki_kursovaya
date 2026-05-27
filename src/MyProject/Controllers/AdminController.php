<?php

namespace MyProject\Controllers;

use MyProject\Models\Pets\Pet;
use MyProject\Models\Feedback\Feedback;
use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;
use MyProject\Services\Auth;
use MyProject\Exceptions\NotFoundException;

class AdminController extends AbstractController
{
    private const PER_PAGE = 10;

    // Белый список колонок для сортировки (защита от SQL-инъекций)
    private const SORT_COLUMNS = [
        'id'         => 'id',
        'name'       => 'name',
        'age_months' => 'age_months',
        'status'     => 'status',
    ];

    // ------------------------ Авторизация ------------------------

    public function loginForm(): void
    {
        if (Auth::isAdmin()) {
            $this->redirect('/admin');
        }
        $this->render('admin/login.php', [
            'title' => 'Вход в панель — Лапки',
            'error' => null,
        ]);
    }

    public function login(): void
    {
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $user = Auth::login($email, $password);
        if ($user === null || !$user->isAdmin()) {
            if ($user !== null && !$user->isAdmin()) {
                Auth::logout();
            }
            $this->render('admin/login.php', [
                'title' => 'Вход в панель — Лапки',
                'error' => 'Неверный e-mail или пароль (либо нет прав администратора).',
            ]);
            return;
        }
        $this->redirect('/admin');
    }

    public function logout(): void
    {
        Auth::logout();
        $this->redirect('/');
    }

    // ------------------------ Дашборд ------------------------

    public function dashboard(): void
    {
        $this->requireAdmin();

        $pets = Pet::findAll();
        $stats = [
            'pets'      => count($pets),
            'available' => count(array_filter($pets, fn(Pet $p) => $p->getStatus() === 'available')),
            'feedback'  => Feedback::countAll(),
        ];

        $this->render('admin/dashboard.php', [
            'title' => 'Панель управления — Лапки',
            'stats' => $stats,
        ]);
    }

    // ------------------ CRUD питомцев (как записная книжка) -------------

    /** Просмотр: таблица с пагинацией и сортировкой. */
    public function petsList(): void
    {
        $this->requireAdmin();

        $sort = $_GET['sort'] ?? 'id';
        $sortColumn = self::SORT_COLUMNS[$sort] ?? 'id';

        $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
        $total = Pet::countAll();
        $totalPages = max(1, (int) ceil($total / self::PER_PAGE));
        if ($page > $totalPages) {
            $page = $totalPages;
        }
        $offset = ($page - 1) * self::PER_PAGE;

        $pets = Pet::findSortedPaginated($sortColumn, self::PER_PAGE, $offset);

        $this->render('admin/pets_list.php', [
            'title'      => 'Питомцы — панель управления',
            'pets'       => $pets,
            'sort'       => $sort,
            'page'       => $page,
            'totalPages' => $totalPages,
            'total'      => $total,
            'notice'     => $_GET['notice'] ?? null,
        ]);
    }

    /** Форма добавления. */
    public function petAddForm(): void
    {
        $this->requireAdmin();
        $this->render('admin/pet_form.php', [
            'title'  => 'Добавить питомца',
            'pet'    => null,
            'mode'   => 'add',
            'errors' => [],
        ]);
    }

    /** Сохранение нового питомца. */
    public function petAdd(): void
    {
        $this->requireAdmin();
        $data = $this->readPetPost();
        $errors = $this->validatePet($data);

        if (!empty($errors)) {
            $this->render('admin/pet_form.php', [
                'title'  => 'Добавить питомца',
                'pet'    => null,
                'mode'   => 'add',
                'errors' => $errors,
                'old'    => $data,
            ]);
            return;
        }

        $pet = new Pet();
        $this->fillPet($pet, $data);
        $pet->save();

        $this->redirect('/admin/pets?notice=added');
    }

    /** Форма редактирования. */
    public function petEditForm(int $petId): void
    {
        $this->requireAdmin();
        $pet = Pet::getById($petId);
        if ($pet === null) {
            throw new NotFoundException('Питомец не найден');
        }
        $this->render('admin/pet_form.php', [
            'title'  => 'Редактировать питомца',
            'pet'    => $pet,
            'mode'   => 'edit',
            'errors' => [],
        ]);
    }

    /** Сохранение изменений. */
    public function petEdit(int $petId): void
    {
        $this->requireAdmin();
        $pet = Pet::getById($petId);
        if ($pet === null) {
            throw new NotFoundException('Питомец не найден');
        }

        $data = $this->readPetPost();
        $errors = $this->validatePet($data);
        if (!empty($errors)) {
            $this->render('admin/pet_form.php', [
                'title'  => 'Редактировать питомца',
                'pet'    => $pet,
                'mode'   => 'edit',
                'errors' => $errors,
                'old'    => $data,
            ]);
            return;
        }

        $this->fillPet($pet, $data);
        $pet->save();

        $this->redirect('/admin/pets?notice=updated');
    }

    /** Удаление записи. */
    public function petDelete(int $petId): void
    {
        $this->requireAdmin();
        $pet = Pet::getById($petId);
        if ($pet !== null) {
            $pet->delete();
        }
        $this->redirect('/admin/pets?notice=deleted');
    }

    // ------------------ CRUD статей (блог) -------------------

    /** Список статей в админке. */
    public function articlesList(): void
    {
        $this->requireAdmin();
        $this->render('admin/articles_list.php', [
            'title'    => 'Статьи — панель управления',
            'articles' => array_reverse(Article::findAll()),
            'notice'   => $_GET['notice'] ?? null,
        ]);
    }

    /** Форма добавления статьи. */
    public function articleAddForm(): void
    {
        $this->requireAdmin();
        $this->render('admin/article_form.php', [
            'title'   => 'Добавить статью',
            'article' => null,
            'mode'    => 'add',
            'errors'  => [],
        ]);
    }

    /** Сохранение новой статьи. */
    public function articleAdd(): void
    {
        $this->requireAdmin();
        $name = trim($_POST['name'] ?? '');
        $text = trim($_POST['text'] ?? '');
        $errors = $this->validateArticle($name, $text);

        if (!empty($errors)) {
            $this->render('admin/article_form.php', [
                'title'  => 'Добавить статью',
                'article' => null,
                'mode'   => 'add',
                'errors' => $errors,
                'old'    => ['name' => $name, 'text' => $text],
            ]);
            return;
        }

        $article = new Article();
        $article->setName($name);
        $article->setText($text);
        // автором назначаем текущего администратора
        $article->setAuthorId(Auth::getCurrentUser()->getId());
        $article->save();

        $this->redirect('/admin/articles?notice=added');
    }

    /** Форма редактирования статьи. */
    public function articleEditForm(int $articleId): void
    {
        $this->requireAdmin();
        $article = Article::getById($articleId);
        if ($article === null) {
            throw new NotFoundException('Статья не найдена');
        }
        $this->render('admin/article_form.php', [
            'title'   => 'Редактировать статью',
            'article' => $article,
            'mode'    => 'edit',
            'errors'  => [],
        ]);
    }

    /** Сохранение изменений статьи. */
    public function articleEdit(int $articleId): void
    {
        $this->requireAdmin();
        $article = Article::getById($articleId);
        if ($article === null) {
            throw new NotFoundException('Статья не найдена');
        }

        $name = trim($_POST['name'] ?? '');
        $text = trim($_POST['text'] ?? '');
        $errors = $this->validateArticle($name, $text);
        if (!empty($errors)) {
            $this->render('admin/article_form.php', [
                'title'  => 'Редактировать статью',
                'article' => $article,
                'mode'   => 'edit',
                'errors' => $errors,
                'old'    => ['name' => $name, 'text' => $text],
            ]);
            return;
        }

        $article->setName($name);
        $article->setText($text);
        $article->save();

        $this->redirect('/admin/articles?notice=updated');
    }

    /** Удаление статьи. */
    public function articleDelete(int $articleId): void
    {
        $this->requireAdmin();
        $article = Article::getById($articleId);
        if ($article !== null) {
            $article->delete();
        }
        $this->redirect('/admin/articles?notice=deleted');
    }

    private function validateArticle(string $name, string $text): array
    {
        $errors = [];
        if ($name === '') {
            $errors[] = 'Укажите заголовок статьи.';
        }
        if (mb_strlen($text) < 20) {
            $errors[] = 'Текст статьи слишком короткий (минимум 20 символов).';
        }
        return $errors;
    }

    // ------------------------ Заявки ------------------------

    public function feedbackList(): void
    {
        $this->requireAdmin();
        $this->render('admin/feedback_list.php', [
            'title'    => 'Обращения — панель управления',
            'messages' => array_reverse(Feedback::findAll()),
        ]);
    }

    // ------------------------ Хелперы ------------------------

    private function readPetPost(): array
    {
        return [
            'name'        => trim($_POST['name'] ?? ''),
            'species'     => $_POST['species'] ?? 'cat',
            'breed'       => trim($_POST['breed'] ?? ''),
            'gender'      => $_POST['gender'] ?? 'male',
            'age_months'  => (int) ($_POST['age_months'] ?? 0),
            'weight_kg'   => (float) ($_POST['weight_kg'] ?? 0),
            'color'       => trim($_POST['color'] ?? ''),
            'activity'    => $_POST['activity'] ?? 'normal',
            'description' => trim($_POST['description'] ?? ''),
            'photo_url'   => trim($_POST['photo_url'] ?? ''),
            'status'      => $_POST['status'] ?? 'available',
        ];
    }

    private function validatePet(array $d): array
    {
        $errors = [];
        if ($d['name'] === '') {
            $errors[] = 'Укажите кличку питомца.';
        }
        if (!in_array($d['species'], ['cat', 'dog', 'other'], true)) {
            $errors[] = 'Некорректный вид животного.';
        }
        if (!in_array($d['gender'], ['male', 'female'], true)) {
            $errors[] = 'Некорректный пол.';
        }
        if ($d['age_months'] < 0) {
            $errors[] = 'Возраст не может быть отрицательным.';
        }
        if ($d['description'] === '') {
            $errors[] = 'Добавьте описание.';
        }
        return $errors;
    }

    private function fillPet(Pet $pet, array $d): void
    {
        $pet->setName($d['name']);
        $pet->setSpecies($d['species']);
        $pet->setBreed($d['breed']);
        $pet->setGender($d['gender']);
        $pet->setAgeMonths($d['age_months']);
        $pet->setWeightKg($d['weight_kg']);
        $pet->setColor($d['color']);
        $pet->setActivity($d['activity']);
        $pet->setDescription($d['description']);
        $pet->setPhotoUrl($d['photo_url'] !== '' ? $d['photo_url'] : '🐾');
        $pet->setStatus($d['status']);
    }
}
