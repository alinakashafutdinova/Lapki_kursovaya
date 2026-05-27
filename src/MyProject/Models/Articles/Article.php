<?php

namespace MyProject\Models\Articles;

use MyProject\Models\ActiveRecordEntity;

class Article extends ActiveRecordEntity
{
    /** @var int */
    protected $authorId;

    /** @var string */
    protected $name;

    /** @var string */
    protected $text;

    /** @var string */
    protected $createdAt;

    public function getName(): string
    {
        return $this->name;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setAuthorId(int $authorId): void
    {
        $this->authorId = $authorId;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /** Краткий анонс для карточки на главной/в списке. */
    public function getExcerpt(int $length = 160): string
    {
        $text = trim($this->text);
        if (mb_strlen($text) <= $length) {
            return $text;
        }
        return mb_substr($text, 0, $length) . '…';
    }

    protected static function getTableName(): string
    {
        return 'articles';
    }
}
