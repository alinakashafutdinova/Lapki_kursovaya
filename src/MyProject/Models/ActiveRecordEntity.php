<?php

namespace MyProject\Models;

use MyProject\Services\Db;

abstract class ActiveRecordEntity
{
    /** @var int */
    protected $id;

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Магический сеттер: PDO при FETCH_CLASS задаёт свойства по именам
     * столбцов (author_id), а у нас они в camelCase (authorId).
     */
    public function __set($name, $value)
    {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }

    private function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $source))));
    }

    private function camelCaseToUnderscore(string $source): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
    }

    /**
     * Собирает ассоциативный массив [столбец => значение] из свойств объекта
     * с помощью рефлексии. Используется при сохранении.
     */
    private function mapPropertiesToDbFormat(): array
    {
        $reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties();

        $mapped = [];
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            if ($propertyName === 'id') {
                continue;
            }
            $dbColumn = $this->camelCaseToUnderscore($propertyName);
            // пропускаем неинициализированные свойства
            if (isset($this->$propertyName)) {
                $mapped[$dbColumn] = $this->$propertyName;
            }
        }
        return $mapped;
    }

    /**
     * Сохраняет объект: если id есть — UPDATE, иначе — INSERT.
     */
    public function save(): void
    {
        $mappedProperties = $this->mapPropertiesToDbFormat();
        if ($this->id !== null) {
            $this->update($mappedProperties);
        } else {
            $this->insert($mappedProperties);
        }
    }

    private function insert(array $mappedProperties): void
    {
        $columns = [];
        $paramsNames = [];
        $params = [];
        foreach ($mappedProperties as $column => $value) {
            $columns[] = '`' . $column . '`';
            $paramName = ':' . $column;
            $paramsNames[] = $paramName;
            $params[$paramName] = $value;
        }

        $sql = 'INSERT INTO `' . static::getTableName() . '` (' . implode(', ', $columns) . ') '
            . 'VALUES (' . implode(', ', $paramsNames) . ');';

        $db = new Db();
        $db->query($sql, $params, static::class);
        $this->id = $db->getLastInsertId();
    }

    private function update(array $mappedProperties): void
    {
        $columns = [];
        $params = [':id' => $this->id];
        foreach ($mappedProperties as $column => $value) {
            $columns[] = '`' . $column . '` = :' . $column;
            $params[':' . $column] = $value;
        }

        $sql = 'UPDATE `' . static::getTableName() . '` SET ' . implode(', ', $columns)
            . ' WHERE id = :id;';

        $db = new Db();
        $db->query($sql, $params, static::class);
    }

    public function delete(): void
    {
        $db = new Db();
        $db->query(
            'DELETE FROM `' . static::getTableName() . '` WHERE id = :id;',
            [':id' => $this->id],
            static::class
        );
    }

    /** Все записи таблицы. */
    public static function findAll(): array
    {
        $db = new Db();
        return $db->query(
            'SELECT * FROM `' . static::getTableName() . '`;',
            [],
            static::class
        ) ?? [];
    }

    /** Одна запись по id или null. */
    public static function getById(int $id): ?self
    {
        $db = new Db();
        $entities = $db->query(
            'SELECT * FROM `' . static::getTableName() . '` WHERE id = :id;',
            [':id' => $id],
            static::class
        );
        return $entities ? $entities[0] : null;
    }

    /** Поиск одной записи по значению столбца (например, по email). */
    public static function findOneByColumn(string $columnName, $value): ?self
    {
        $db = new Db();
        $result = $db->query(
            'SELECT * FROM `' . static::getTableName() . '` WHERE `' . $columnName . '` = :value LIMIT 1;',
            [':value' => $value],
            static::class
        );
        return $result ? $result[0] : null;
    }

    /** Общее количество записей (для пагинации). */
    public static function countAll(): int
    {
        $db = new Db();
        $result = $db->query(
            'SELECT COUNT(*) AS cnt FROM `' . static::getTableName() . '`;'
        );
        return $result ? (int) $result[0]->cnt : 0;
    }

    /**
     * Записи с сортировкой и пагинацией.
     * $sortColumn — белый список проверяется в вызывающем коде.
     */
    public static function findSortedPaginated(string $sortColumn, int $limit, int $offset): array
    {
        $db = new Db();
        $sql = 'SELECT * FROM `' . static::getTableName() . '` '
            . 'ORDER BY `' . $sortColumn . '` ASC '
            . 'LIMIT ' . (int) $limit . ' OFFSET ' . (int) $offset . ';';
        return $db->query($sql, [], static::class) ?? [];
    }

    abstract protected static function getTableName(): string;
}
