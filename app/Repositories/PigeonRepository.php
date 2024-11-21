<?php

namespace App\Repositories;

use App\Models\Pigeon;
use Illuminate\Database\Eloquent\Builder;

class PigeonRepository
{
    protected Builder $builder;

    public function __construct(
        private readonly Pigeon $pigeon
    )
    {
        $this->builder = $this->pigeon->newQuery();
    }

    public function store(array $data): Pigeon
    {
        return $this->builder->create($data);
    }
}
