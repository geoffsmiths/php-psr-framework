<?php

namespace App\Blog\Repository\Domain;

use http\Exception\InvalidArgumentException;

class BlogName
{
    const MAX_LENGTH = 100;

    /**
     * @var string
     */
    private $name;

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function fromString(string $name): BlogName
    {
        self::ensureIsValidName($name);

        return new self($name);
    }

    public function toString(): string
    {
        return $this->name;
    }

    private static function ensureIsValidName(string $name)
    {
        if (strlen($name) === 0) {
            throw new InvalidArgumentException('BlogName is not set');
        }

        if (strlen($name) > self::MAX_LENGTH) {
            throw new InvalidArgumentException('BlogName exceeds ' . self::MAX_LENGTH . ' characters.');
        }
    }
}
