<?php

namespace App\Repositories;

use App\Models\Auction;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\Uid\UuidV4;

class AuctionRepository
{
    protected Builder $builder;

    public function __construct(
        private readonly Auction $auction
    )
    {
        $this->builder = $this->auction->newQuery();
    }

    public function store(array $data): Auction
    {
        $data['uuid'] = new UuidV4();
        return $this->builder->create($data);
    }
}