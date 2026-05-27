<?php

namespace MyProject\Models\Users;

use MyProject\Models\ActiveRecordEntity;

class User extends ActiveRecordEntity
{
    /** @var string */
    protected $nickname;

    /** @var string */
    protected $email;

    /** @var string */
    protected $passwordHash;

    /** @var string */
    protected $role;

    /** @var string */
    protected $createdAt;

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /** Проверяет введённый пароль на соответствие сохранённому хешу. */
    public function checkPassword(string $password): bool
    {
        return password_verify($password, $this->passwordHash);
    }

    protected static function getTableName(): string
    {
        return 'users';
    }
}
