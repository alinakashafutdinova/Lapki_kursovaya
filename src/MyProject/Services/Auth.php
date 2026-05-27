<?php

namespace MyProject\Services;

use MyProject\Models\Users\User;

class Auth
{
    private static function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /** Пытается авторизовать пользователя по email и паролю. */
    public static function login(string $email, string $password): ?User
    {
        $user = User::findOneByColumn('email', $email);
        if ($user === null || !$user->checkPassword($password)) {
            return null;
        }
        self::startSession();
        $_SESSION['user_id'] = $user->getId();
        return $user;
    }

    public static function logout(): void
    {
        self::startSession();
        unset($_SESSION['user_id']);
    }

    /** Текущий авторизованный пользователь или null. */
    public static function getCurrentUser(): ?User
    {
        self::startSession();
        if (empty($_SESSION['user_id'])) {
            return null;
        }
        return User::getById((int) $_SESSION['user_id']);
    }

    public static function isAdmin(): bool
    {
        $user = self::getCurrentUser();
        return $user !== null && $user->isAdmin();
    }
}
