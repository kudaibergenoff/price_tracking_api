<?php

namespace App\Services;

use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Services\UserServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function get(array $params): Model
    {
        return $this->repository->get($params);
    }

    public function create(array $params): Model
    {
        data_set($params, 'password', Hash::make($params['password']));

        return $this->repository->create($params);
    }
}
