<?php

namespace App\Blog\Repository\Domain;

class Blog
{
    /**
     * @var BlogId
     */
    protected $id;

    /**
     * @var BlogName
     */
    protected $name;

    /**
     * @var BlogDescription
     */
    protected $description;

    /**
     * @var BlogStatus
     */
    protected $status;

    private function __construct(BlogId $id, BlogName $name, BlogDescription $description, BlogStatus $status)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->status = $status;
    }

    public static function draft(BlogId $id, BlogName $name, BlogDescription $description, BlogStatus $status): Blog
    {
        return new self($id, $name, $description, $status);
    }

    public static function fromState(array $state): Blog
    {
        return new self(
            BlogId::fromInt($state['id']),
            BlogName::fromString($state['name']),
            BlogDescription::fromString($state['description']),
            BlogStatus::fromString($state['status'])
        );
    }

    public function getId(): BlogId
    {
        return $this->id;
    }

    public function getName(): BlogName
    {
        return $this->name;
    }

    public function getDescription(): BlogDescription
    {
        return $this->description;
    }

    public function getStatus(): BlogStatus
    {
        return $this->status;
    }
}
