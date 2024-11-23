<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Http\Requests\AuctionAutoBidRequest;
use App\Http\Requests\AuctionBidRequest;
use App\Http\Requests\AuctionStoreRequest;
use App\Models\Auction;
use App\Models\AuctionConfig;
use App\Repositories\AuctionAutoBidRepository;
use App\Repositories\AuctionHistoryRepository;
use App\Repositories\AuctionRepository;
use App\Socket\SocketService;
use Exception;
use Illuminate\Support\Facades\Cache;

class AuctionController extends Controller
{
    protected AuctionConfig $config;
    public function __construct(
        public readonly AuctionRepository $auctionRepository,
        public readonly AuctionHistoryRepository $auctionHistoryRepository,
        public readonly SocketService            $socketService,
        public readonly AuctionAutoBidRepository $auctionAutoBidRepository,
    )
    {
        $this->config = Cache::get('auction.config');
    }

    public function store(AuctionStoreRequest $request)
    {
        $data = $request->validated();
        $result = $this->auctionRepository->store($data);
        return response()->json($result, 201);
    }

    public function autoBid(AuctionAutoBidRequest $request)
    {
        try {
            $bid = $request->post('bid');
            $uuid = $request->post('auction');
            $userId = $request->post('user_id');
            $auction = $this->auctionRepository->find($uuid);
            $this->bidValidation(
                $userId,
                $auction,
                $bid
            );
            $autoBidData = [
                'user_id' => $userId,
                'auction_id' => $auction->id,
                'bid' => $bid,
            ];
            $this->auctionAutoBidRepository->updateOrCreate($autoBidData);
            return response()->json([], 201);
        } catch (Exception $exception) {
            return response()->json([
                "message" => $exception->getMessage(),
                "errors" => [
                    "general_error" => [
                        $exception->getMessage()
                    ]
                ]
            ], 422);
        }
    }

    public function bid(AuctionBidRequest $request)
    {
        try {
            $bid = $request->post('bid');
            $uuid = $request->post('auction');
            $userId = $request->post('user_id');
            $auction = $this->auctionRepository->find($uuid);
            $this->bidValidation(
                $userId,
                $auction,
                $bid
            );
            $this->auctionHistoryRepository->store([
                'auction_id' => $auction->id,
                'bid' => $bid,
                'user_id' => $userId,
            ]);
            $this->socketService->storeBid(
                $request->post('auction')
            );
            return response()->json([], 201);

        } catch (Exception $exception) {
            return response()->json([
                "message" => $exception->getMessage(),
                "errors" => [
                    "general_error" => [
                        $exception->getMessage()
                    ]
                ]
            ], 422);
        }
    }

    protected function bidValidation(int $userId, Auction $auction, int $bid): void
    {
//      if (Auth::id() == $userId) throw new Exception('Kendi ihalenize pay veremezsiniz');
        $limits = $this->config->limits;
        $lastBid = $this->auctionHistoryRepository->lastBid($auction->id);
        if ($bid <= $lastBid->bid) throw new Exception('En son payi gecmelisiniz');
        Helper::validateAndCalculateValue($bid, $limits);
        Helper::validateDateTime($auction->start_date, $auction->end_date);
    }
}
