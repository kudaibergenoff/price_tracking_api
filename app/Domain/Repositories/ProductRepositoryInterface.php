<?php

namespace App\Domain\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ProductRepositoryInterface
{
    public function create(array $params): Model;

    public function update(int $id, array $params): Model;

    public function delete(int $id): bool;

    public function get(int $id): Model;

    public function getList(): Collection;
}
