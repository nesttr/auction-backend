<?php

namespace App\Repositories;

use App\Models\PigeonImage;
use Illuminate\Database\Eloquent\Builder;

class PigeonImageRepository
{
    protected Builder $builder;

    public function __construct(
        private readonly PigeonImage $pigeonImage
    )
    {
        $this->builder = $this->pigeonImage->newQuery();
    }

    public function store(array $data): PigeonImage
    {
        return $this->builder->create($data);
    }
}
