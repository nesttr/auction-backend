<?php

namespace App\services;

use App\Helper;
use App\Models\AuctionConfig;
use App\Repositories\AuctionAutoBidRepository;
use App\Repositories\AuctionHistoryRepository;
use App\Repositories\AuctionRepository;
use App\Socket\SocketService;
use Exception;
use Illuminate\Support\Arr;
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
//        $this->auctionHistoryRepository->store($data);
//        $this->socketService->storeBid(
//            $auction->uuid
//        );
        $autoBidList = $this->auctionAutoBidRepository->getByAuctionId($auction->id);
        $this->automationBig($autoBidList, $lastBid);
    }

    protected function automationBig($bidders, int $currentBid)
    {
        $bidders = $bidders->toArray();
        $limits = $this->config->limits;
        $result = [];
        $round = 0; // Artırma tur sayacı
        while (true) {
            // Artırma yapabilecek kullanıcıları filtrele
            $eligibleBidders = array_filter($bidders, function ($bidder) use ($currentBid, $limits) {
                $increment = Helper::getMinimumIncrement($limits, $currentBid);
                return $currentBid + $increment <= $bidder['bid'];
            });
            // Eğer artırma yapabilecek kimse kalmadıysa döngüyü sonlandır
            if (empty($eligibleBidders)) {
                break;
            }
            // Artırma yapabilecek kullanıcılar arasında sırayla işlem yap
            foreach ($eligibleBidders as $bidder) {
                $increment = Helper::getMinimumIncrement($limits, $currentBid);
                // Kullanıcının sınırını kontrol et ve artırmayı gerçekleştir
                if ($currentBid + $increment <= $bidder['bid']) {
                    $currentBid += $increment;
                    $result[] = [
                        'round' => ++$round,
                        'user_id' => $bidder['user_id'],
                        'bid' => $currentBid,
                        'auction_id' => $bidder['auction_id'],
                    ];
                }
                // Eğer artırma yapacak başka kimse kalmadıysa döngüyü sonlandır
                $remainingEligibleBidders = array_filter($eligibleBidders, function ($bidder) use ($currentBid, $limits) {
                    $increment = Helper::getMinimumIncrement($limits, $currentBid);
                    return [$bidder['user_id'],$currentBid + $increment <= $bidder['bid']];
                });
                if (count($remainingEligibleBidders) == 1) {
//                    $first = Arr::first( $remainingEligibleBidders);
//                    $currentBid += $increment;
//                    $result[] = [
//                        'round' => ++$round,
//                        'user_id' => $first['user_id'],
//                        'bid' => $currentBid,
//                        'auction_id' => $bidder['auction_id'],
//                    ];
                    break 2;
                }
            }
        }
        dd($result);
        return $result;
    }
}
