<?php

namespace App\Repositories;

use App\Domain\Repositories\UserProductRepositoryInterface;
use App\Models\UserProduct;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserProductRepository implements UserProductRepositoryInterface
{
    public function create(array $params): Model
    {
        return UserProduct::query()
            ->create($params);
    }

    public function delete(int $id): bool
    {
        $userProduct = $this->get($id);

        return $userProduct->delete();
    }

    public function getUserProducts(int $userId): Collection
    {
        return UserProduct::query()
            ->with(['product'])
            ->where('user_id', '=', $userId)
            ->get();
    }

    public function get(int $id): Model
    {
        return UserProduct::query()->findOrFail($id);
    }
}
