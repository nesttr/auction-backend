<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsStoreRequest;
use App\Repositories\NewsRepository;
use Illuminate\Http\JsonResponse;

class NewsController extends Controller
{
    public function __construct(
        public readonly NewsRepository $newsRepository,
    )
    {
    }

    public function store(NewsStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $result = $this->newsRepository->store($data);
        return response()->json($result, 201);
    }
}
