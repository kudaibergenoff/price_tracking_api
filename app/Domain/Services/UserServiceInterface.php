<?php

namespace App\Domain\Services;

use Illuminate\Database\Eloquent\Model;

interface UserServiceInterface
{
    public function get(array $params): Model;

    public function create(array $params): Model;
}
