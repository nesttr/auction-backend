<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfileStoreRequest;
use App\Repositories\UserProfileRepository;
use Illuminate\Http\JsonResponse;

class UserProfileController extends Controller
{
    public function __construct(
        public readonly UserProfileRepository $profileRepository
    )
    {
    }

    public function store(UserProfileStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $result = $this->profileRepository->store($validated['user_id'], $validated);
        return response()->json($result, 201);
    }
}
