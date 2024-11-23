<?php

namespace App\Repositories;

use App\Models\AuctionHistory;
use Illuminate\Database\Eloquent\Builder;

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

    public function lastBid(int $auctionId)
    {
        return $this->builder
            ->select('bid')
            ->where('auction_id', $auctionId)
            ->orderBy('id','desc')
            ->limit(1)
            ->first();
    }
}
