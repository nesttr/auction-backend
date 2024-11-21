<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuctionStoreRequest;
use App\Repositories\AuctionRepository;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    public function __construct(
        public readonly AuctionRepository $auctionRepository,
    )
    {
    }

    public function store(AuctionStoreRequest $request)
    {
        $data = $request->validated();
        $result = $this->auctionRepository->store($data);
        return response()->json($result, 201);
    }
}
