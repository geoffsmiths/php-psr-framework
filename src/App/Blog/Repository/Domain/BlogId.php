<?php

namespace App\Blog\Repository\Domain;

use http\Exception\InvalidArgumentException;

class BlogId
{
    protected $id;

    private function __construct(int $id)
    {
        $this->id = $id;
    }

    public static function fromInt(int $id): BlogId
    {
        self::ensureIsValidInt($id);

        return new self($id);
    }

    public function toInt(): int
    {
        return $this->id;
    }

    private static function ensureIsValidInt(int $id)
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('Invalid BlogID given');
        }
    }
}
