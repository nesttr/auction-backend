<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuctionAutoBidRequest;
use App\Http\Requests\AuctionBidRequest;
use App\Http\Requests\AuctionStoreRequest;
use App\Repositories\AuctionRepository;
use App\services\AuctionService;
use Exception;
use Illuminate\Http\JsonResponse;

class AuctionController extends Controller
{
    public function __construct(
        public readonly AuctionRepository $auctionRepository,
        public readonly AuctionService    $auctionService
    )
    {

    }

    public function store(AuctionStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $result = $this->auctionRepository->store($data);
        return response()->json($result, 201);
    }

    public function autoBid(AuctionAutoBidRequest $request): JsonResponse
    {
        try {
            $bid = $request->post('bid');
            $uuid = $request->post('auction');
            $userId = $request->post('user_id');
            $this->auctionService->bid($userId, $uuid, $bid, true);
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
            $this->auctionService->bid($userId, $uuid, $bid);
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

}
