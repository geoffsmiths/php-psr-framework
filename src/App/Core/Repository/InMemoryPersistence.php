<?php

namespace App\Core\Repository;

class InMemoryPersistence implements PersistenceInterface
{
    private $data = [];

    private $lastId = 0;

    public function generateId(): int
    {
        $this->lastId++;

        return $this->lastId;
    }

    public function persist(array $data)
    {
        $this->data[$this->lastId] = $data;
    }

    /**
     * @param int $id
     *
     * @return mixed
     * @throws OutOfBoundsException
     */
    public function retrieve(int $id)
    {
        if (!isset($this->data[$id])) {
            throw new OutOfBoundsException(sprintf('No data found for ID %d', $id));
        }

        return $this->data[$id];
    }

    /**
     * @param int $id
     *
     * @return mixed
     * @throws OutOfBoundsException
     */
    public function delete(int $id)
    {
        if (!isset($this->data[$id])) {
            throw new OutOfBoundsException(sprintf('No data found for ID %d', $id));
        }

        unset($this->data[$id]);
    }
}
