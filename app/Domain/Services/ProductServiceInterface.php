<?php

namespace App\Domain\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ProductServiceInterface
{
    public function create(array $params): Model;

    public function update(int $id, array $params): Model;

    public function delete(int $id): bool;

    public function getList(): Collection;
}
