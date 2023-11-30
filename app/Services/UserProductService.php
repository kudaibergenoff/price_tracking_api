<?php

namespace App\Services;

use App\Domain\Repositories\UserProductRepositoryInterface;
use App\Domain\Services\UserProductServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserProductService implements UserProductServiceInterface
{
    private UserProductRepositoryInterface $repository;

    public function __construct(UserProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function create(array $params): Model
    {
        data_set($params, 'user_id', request()->user->id);

        return $this->repository->create($params);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }

    public function getUserProducts(): Collection
    {
        return $this->repository->getUserProducts(request()->user->id);
    }
}
