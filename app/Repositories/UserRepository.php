<?php

namespace App\Repositories;

use App\Domain\Repositories\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserRepository implements UserRepositoryInterface
{
    public function get(array $params): Model
    {
        return User::query()
            ->where($params)
            ->firstOrFail();
    }

    public function create(array $params): Model
    {
        return User::query()
            ->create($params);
    }
}
