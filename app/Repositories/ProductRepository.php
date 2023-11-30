<?php

namespace App\Repositories;

use App\Domain\Repositories\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProductRepository implements ProductRepositoryInterface
{
    public function create(array $params): Model
    {
        return Product::query()->create($params);
    }

    public function update(int $id, array $params): Model
    {
        $product = $this->get($id);
        $product->update($params);

        return $product;
    }

    public function delete(int $id): bool
    {
        $product = $this->get($id);

        return $product->delete();
    }

    public function getList(): Collection
    {
        return Product::all();
    }

    public function get(int $id): Model
    {
        return Product::query()->findOrFail($id);
    }
}
