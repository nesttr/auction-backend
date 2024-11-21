<?php

namespace App\Repositories;

use App\Models\AuctionHistory;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\Uid\UuidV4;

class AuctionHistoryRepository
{
    protected Builder $builder;

    public function __construct(
        private readonly AuctionHistory $auction
    )
    {
        $this->builder = $this->auction->newQuery();
    }

    public function store(array $data): AuctionHistory
    {
        return $this->builder->create($data);
    }
}
