<?php

namespace App\Domain\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface UserProductServiceInterface
{
    public function create(array $params): Model;

    public function delete(int $id): bool;

    public function getUserProducts(): Collection;
}
