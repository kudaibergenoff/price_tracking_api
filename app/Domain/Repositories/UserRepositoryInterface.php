<?php

namespace App\Domain\Repositories;

use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface
{
    public function get(array $params): Model;

    public function create(array $params): Model;
}
