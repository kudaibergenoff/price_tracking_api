<?php

namespace App\Services;

use App\Domain\Repositories\ProductRepositoryInterface;
use App\Domain\Services\ProductServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProductService implements ProductServiceInterface
{
    private ProductRepositoryInterface $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function create(array $params): Model
    {
        return $this->repository->create($params);
    }

    public function update(int $id, array $params): Model
    {
        return $this->repository->update($id, $params);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }

    public function getList(): Collection
    {
        return $this->repository->getList();
    }
}
