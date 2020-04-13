<?php

namespace App\Core\Repository;

interface PersistenceInterface
{
    public function generateId(): int;

    public function persist(array $data);

    public function retrieve(int $id);

    public function delete(int $id);
}
