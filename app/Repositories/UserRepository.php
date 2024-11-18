<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserRepository
{
    protected Builder $builder;

    public function __construct(
        private readonly User $user
    )
    {
        $this->builder = $this->user->newQuery();
    }

    public function store(array $data): User
    {
        return $this->builder->create($data);
    }
}
