<?php

namespace App\Repositories;

use App\Models\AutomaticBid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class AuctionAutoBidRepository
{
    protected Builder $builder;

    public function __construct(
        private readonly AutomaticBid $auction
    )
    {
        $this->builder = $this->auction->newQuery();
    }

    public function getByAuctionId(int $id): Collection
    {
        return $this->builder->select(['user_id','bid','auction_id'])
            ->where('auction_id', $id)
            ->get();
    }

    public function updateOrCreate(array $data): AutomaticBid
    {
        return $this->builder->updateOrCreate([
            'user_id' => $data['user_id'],
            'auction_id' => $data['auction_id']
        ], $data);
    }
}
