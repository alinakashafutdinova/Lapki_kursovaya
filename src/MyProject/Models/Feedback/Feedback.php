<?php

namespace MyProject\Models\Feedback;

use MyProject\Models\ActiveRecordEntity;

class Feedback extends ActiveRecordEntity
{
    /** @var string */
    protected $name;
    /** @var string */
    protected $email;
    /** @var string */
    protected $type;
    /** @var string */
    protected $message;
    /** @var int */
    protected $replySms;
    /** @var int */
    protected $replyEmail;
    /** @var string */
    protected $createdAt;

    public function getName(): string    { return $this->name; }
    public function getEmail(): string   { return $this->email; }
    public function getType(): string    { return $this->type; }
    public function getMessage(): string { return $this->message; }
    public function getReplySms(): int   { return (int) $this->replySms; }
    public function getReplyEmail(): int { return (int) $this->replyEmail; }
    public function getCreatedAt(): string { return $this->createdAt; }

    public function setName(string $v): void    { $this->name = $v; }
    public function setEmail(string $v): void   { $this->email = $v; }
    public function setType(string $v): void    { $this->type = $v; }
    public function setMessage(string $v): void { $this->message = $v; }
    public function setReplySms(int $v): void    { $this->replySms = $v; }
    public function setReplyEmail(int $v): void  { $this->replyEmail = $v; }

    public function getTypeLabel(): string
    {
        return [
            'adopt'     => 'Хочу забрать питомца',
            'volunteer' => 'Стать волонтёром',
            'question'  => 'Вопрос',
            'gratitude' => 'Благодарность',
        ][$this->type] ?? $this->type;
    }

    /** Список выбранных способов ответа. */
    public function getReplyMethods(): string
    {
        $methods = [];
        if ($this->replySms)   { $methods[] = 'СМС'; }
        if ($this->replyEmail) { $methods[] = 'E-mail'; }
        return $methods ? implode(', ', $methods) : '—';
    }

    protected static function getTableName(): string
    {
        return 'feedback';
    }
}
