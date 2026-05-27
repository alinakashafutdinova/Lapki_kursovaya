<?php

namespace MyProject\Models\Pets;

use MyProject\Models\ActiveRecordEntity;

class Pet extends ActiveRecordEntity
{
    /** @var string */
    protected $name;
    /** @var string */
    protected $species;
    /** @var string */
    protected $breed;
    /** @var string */
    protected $gender;
    /** @var int */
    protected $ageMonths;
    /** @var float */
    protected $weightKg;
    /** @var string */
    protected $color;
    /** @var string */
    protected $activity;
    /** @var string */
    protected $description;
    /** @var string */
    protected $photoUrl;
    /** @var string */
    protected $status;
    /** @var string */
    protected $createdAt;

    // ---------- Геттеры ----------
    public function getName(): string       { return $this->name; }
    public function getSpecies(): string    { return $this->species; }
    public function getBreed(): string      { return $this->breed; }
    public function getGender(): string     { return $this->gender; }
    public function getAgeMonths(): int     { return (int) $this->ageMonths; }
    public function getWeightKg(): float    { return (float) $this->weightKg; }
    public function getColor(): string      { return $this->color; }
    public function getActivity(): string   { return $this->activity; }
    public function getDescription(): string{ return $this->description; }
    public function getPhotoUrl(): string   { return $this->photoUrl; }
    public function getStatus(): string     { return $this->status; }

    // ---------- Сеттеры (для форм админки) ----------
    public function setName(string $v): void        { $this->name = $v; }
    public function setSpecies(string $v): void     { $this->species = $v; }
    public function setBreed(string $v): void       { $this->breed = $v; }
    public function setGender(string $v): void      { $this->gender = $v; }
    public function setAgeMonths(int $v): void       { $this->ageMonths = $v; }
    public function setWeightKg(float $v): void      { $this->weightKg = $v; }
    public function setColor(string $v): void       { $this->color = $v; }
    public function setActivity(string $v): void    { $this->activity = $v; }
    public function setDescription(string $v): void { $this->description = $v; }
    public function setPhotoUrl(string $v): void    { $this->photoUrl = $v; }
    public function setStatus(string $v): void      { $this->status = $v; }

    // ---------- Фото питомца ----------
    /**
     * Возвращает URL настоящей фотографии питомца.
     * Если в photo_url задана ссылка (http...) или локальный файл (/uploads/..) —
     * используется она. Иначе подбирается настоящее фото по виду животного
     * (детерминированно по id) с бесплатного фотосервиса.
     */
    public function getImageUrl(): string
    {
        $val = trim((string) $this->photoUrl);
        if ($val !== '' && (strpos($val, 'http') === 0 || strpos($val, '/') === 0)) {
            return $val;
        }
        $id = $this->id ?: 1;
        if ($this->species === 'dog') {
            // placedog.net — стабильный сервис фото собак, детерминированно по id
            return 'https://placedog.net/640/480?id=' . (($id % 200) + 1);
        }
        $keyword = $this->species === 'other' ? 'parrot,bird' : 'cat,kitten';
        // loremflickr — настоящие фото по ключевому слову, lock делает выбор постоянным
        return 'https://loremflickr.com/640/480/' . $keyword . '?lock=' . $id;
    }

    /** Эмодзи-заглушка на случай, если фото не загрузилось. */
    public function getPhotoEmoji(): string
    {
        $val = trim((string) $this->photoUrl);
        if ($val !== '' && strpos($val, 'http') !== 0 && strpos($val, '/') !== 0) {
            return $val; // в photo_url лежит эмодзи
        }
        return ['cat' => '🐱', 'dog' => '🐶', 'other' => '🐇'][$this->species] ?? '🐾';
    }

    // ---------- Человекочитаемые ярлыки ----------
    public function getSpeciesLabel(): string
    {
        return ['cat' => 'Кошка', 'dog' => 'Собака', 'other' => 'Другое'][$this->species] ?? $this->species;
    }

    public function getGenderLabel(): string
    {
        return ['male' => 'Мальчик', 'female' => 'Девочка'][$this->gender] ?? $this->gender;
    }

    public function getActivityLabel(): string
    {
        return ['low' => 'Низкая', 'normal' => 'Средняя', 'high' => 'Высокая'][$this->activity] ?? $this->activity;
    }

    public function getStatusLabel(): string
    {
        return ['available' => 'Ищет дом', 'reserved' => 'Забронирован', 'adopted' => 'Дома'][$this->status] ?? $this->status;
    }

    /** Возраст словами: «2 года 3 мес.» */
    public function getAgeLabel(): string
    {
        $years = intdiv($this->ageMonths, 12);
        $months = $this->ageMonths % 12;
        $parts = [];
        if ($years > 0) {
            $parts[] = $years . ' ' . self::plural($years, 'год', 'года', 'лет');
        }
        if ($months > 0) {
            $parts[] = $months . ' ' . self::plural($months, 'месяц', 'месяца', 'месяцев');
        }
        return $parts ? implode(' ', $parts) : 'меньше месяца';
    }

    private static function plural(int $n, string $one, string $few, string $many): string
    {
        $n = abs($n) % 100;
        $n1 = $n % 10;
        if ($n > 10 && $n < 20) return $many;
        if ($n1 > 1 && $n1 < 5) return $few;
        if ($n1 === 1) return $one;
        return $many;
    }

    protected static function getTableName(): string
    {
        return 'pets';
    }
}
