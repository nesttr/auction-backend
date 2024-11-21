<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuctionBidRequest;
use App\Http\Requests\AuctionStoreRequest;
use App\Repositories\AuctionHistoryRepository;
use App\Repositories\AuctionRepository;
use App\Socket\SocketService;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    public function __construct(
        public readonly AuctionRepository $auctionRepository,
        public readonly AuctionHistoryRepository $auctionHistoryRepository,
        public readonly SocketService $socketService
    )
    {
    }

    public function store(AuctionStoreRequest $request)
    {
        $data = $request->validated();
        $result = $this->auctionRepository->store($data);
        return response()->json($result, 201);
    }

    public function bid(AuctionBidRequest $request)
    {
        $auction = $this->auctionRepository->find($request->post('auction'));
        $this->auctionHistoryRepository->store([
            'auction_id' => $auction->id,
            'bid' => $request->post('bid'),
            'user_id' => $request->post('user_id'),
        ]);
        $this->socketService->storeBid(
            $request->post('auction')
        );
    }
}
