<?php

namespace App\Blog\Repository\Domain;

use http\Exception\InvalidArgumentException;

class BlogDescription
{
    const MAX_LENGTH = 255;
    /**
     * @var string
     */
    private $description;

    private function __construct(string $description)
    {
        $this->description = $description;
    }

    public static function fromString(string $description): BlogDescription
    {
        self::ensureIsValidString($description);

        return new self($description);
    }

    public function toString(): string
    {
        return $this->description;
    }

    private static function ensureIsValidString(string $description)
    {
        if (strlen($description) === 0) {
            throw new InvalidArgumentException('BlogDescription is not set');
        }

        if (strlen($description) > self::MAX_LENGTH) {
            throw new InvalidArgumentException('BlogDescription exceeds ' . self::MAX_LENGTH . ' characters.');
        }
    }
}
