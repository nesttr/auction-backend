<?php

namespace App\services;

use App\Helper;
use App\Models\AuctionConfig;
use App\Repositories\AuctionAutoBidRepository;
use App\Repositories\AuctionHistoryRepository;
use App\Repositories\AuctionRepository;
use App\Socket\SocketService;
use Exception;
use Illuminate\Support\Facades\Cache;

class AuctionService
{
    protected AuctionConfig $config;

    public function __construct(
        protected readonly AuctionRepository        $auctionRepository,
        protected readonly AuctionHistoryRepository $auctionHistoryRepository,
        protected readonly AuctionAutoBidRepository $auctionAutoBidRepository,
        protected readonly SocketService            $socketService,
    )
    {
        $this->config = Cache::get('auction.config');
    }

    /**
     * @throws Exception
     */
    public function bid(
        int    $userId,
        string $uuid,
        int    $bid,
        bool   $isAutoBid = false
    ): void
    {
//      if (Auth::id() == $userId) throw new Exception('Kendi ihalenize pay veremezsiniz');
        $auction = $this->auctionRepository->find($uuid);
        $autoBidList =  $this->auctionAutoBidRepository->getByAuctionId($auction->id);
        foreach ($autoBidList as $autoBid) {

        }
        Helper::validateDateTime($auction->start_date, $auction->end_date);

        $lastBidResult = $this->auctionHistoryRepository->lastBid($auction->id);
        $lastBid = $lastBidResult->bid ?? 0;
        Helper::validateAndCalculateValue($lastBid, $bid, $this->config->limits);
        $data = [
            'user_id' => $userId,
            'auction_id' => $auction->id,
            'bid' => $bid,
        ];
        if ($isAutoBid) {
            $minIncrement = Helper::getMinimumIncrement($this->config->limits, $lastBid);
            $nextBid = $lastBid + $minIncrement;
            $this->auctionAutoBidRepository->updateOrCreate($data);
            $data['bid'] = $nextBid;
        }
        $this->auctionHistoryRepository->store($data);

        $this->socketService->storeBid(
            $auction->uuid
        );
    }
}
