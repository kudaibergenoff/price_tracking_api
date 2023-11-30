<?php

namespace App\Domain\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface UserProductRepositoryInterface
{
    public function create(array $params): Model;

    public function delete(int $id): bool;

    public function getUserProducts(int $userId): Collection;

    public function get(int $id): Model;
}
