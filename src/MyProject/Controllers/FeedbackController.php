<?php

namespace MyProject\Controllers;

use MyProject\Models\Feedback\Feedback;

class FeedbackController extends AbstractController
{
    /** Показ формы обратной связи. */
    public function form(): void
    {
        $this->render('feedback/form.php', [
            'title'   => 'Связаться с нами — Лапки',
            'sent'    => isset($_GET['sent']),
            'errors'  => [],
            'old'     => [],
        ]);
    }

    /**
     * Обработка отправки формы (метод POST).
     * Лаба 1: поля имя, e-mail, тип обращения, текст, чекбоксы способа ответа.
     */
    public function submit(): void
    {
        $name    = trim($_POST['name'] ?? '');
        $email   = trim($_POST['email'] ?? '');
        $type    = $_POST['type'] ?? '';
        $message = trim($_POST['message'] ?? '');
        $reply   = $_POST['reply'] ?? [];

        // Валидация
        $errors = [];
        if ($name === '') {
            $errors[] = 'Укажите имя.';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Укажите корректный e-mail.';
        }
        if (!in_array($type, ['adopt', 'volunteer', 'question', 'gratitude'], true)) {
            $errors[] = 'Выберите тип обращения.';
        }
        if ($message === '') {
            $errors[] = 'Напишите текст обращения.';
        }

        if (!empty($errors)) {
            $this->render('feedback/form.php', [
                'title'  => 'Связаться с нами — Лапки',
                'sent'   => false,
                'errors' => $errors,
                'old'    => compact('name', 'email', 'type', 'message'),
            ]);
            return;
        }

        // Сохраняем обращение в базу данных
        $feedback = new Feedback();
        $feedback->setName($name);
        $feedback->setEmail($email);
        $feedback->setType($type);
        $feedback->setMessage($message);
        $feedback->setReplySms(in_array('sms', (array) $reply, true) ? 1 : 0);
        $feedback->setReplyEmail(in_array('email', (array) $reply, true) ? 1 : 0);
        $feedback->save();

        // Перенаправляем с флагом успеха (паттерн POST-Redirect-GET)
        $this->redirect('/feedback?sent=1');
    }
}
