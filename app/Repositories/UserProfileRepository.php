<?php

namespace App\Repositories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserProfileRepository
{
    protected Builder $builder;

    public function __construct(
        private readonly Profile $profile
    )
    {
        $this->builder = $this->profile->newQuery();
    }

    public function store(int $userId, array $data): Profile
    {
        return $this->builder->updateOrCreate(['user_id'=>$userId],$data);
    }
}
