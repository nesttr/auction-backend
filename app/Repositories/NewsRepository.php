<?php

namespace App\Repositories;

use App\Models\News;
use Illuminate\Database\Eloquent\Builder;

class NewsRepository
{
    protected Builder $builder;

    public function __construct(
        private readonly News $news
    )
    {
        $this->builder = $this->news->newQuery();
    }

    public function store(array $data): News
    {
        return $this->builder->create($data);
    }
}
