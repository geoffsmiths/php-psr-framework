<?php

namespace App\Blog\Repository\Domain;

class BlogStatus
{
    const STATE_DRAFT_ID = 0;
    const STATE_PUBLISHED_ID = 1;

    const STATE_DRAFT = 'draft';
    const STATE_PUBLISHED = 'published';

    const VALID_STATES = [
        self::STATE_DRAFT_ID => self::STATE_DRAFT,
        self::STATE_PUBLISHED_ID => self::STATE_PUBLISHED,
    ];

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    private function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public static function fromInt(int $id): BlogStatus
    {
        self::ensureIsValidId($id);

        return new self($id, self::VALID_STATES[$id]);
    }

    public function toInt(): int
    {
        return $this->id;
    }

    public static function fromString(string $name): BlogStatus
    {
        self::ensureIsValidString($name);

        return new self(array_search($name, self::VALID_STATES), $name);
    }

    public function toString(): string
    {
        return $this->name;
    }

    private static function ensureIsValidId(int $id)
    {
        if (!array_key_exists($id, self::VALID_STATES)) {
            throw new \InvalidArgumentException('Invalid BlogStatus ID');
        }
    }

    private static function ensureIsValidString(string $name)
    {
        if (!in_array($name, self::VALID_STATES)) {
            throw new \InvalidArgumentException('Invalid BlogStatus name');
        }
    }
}
