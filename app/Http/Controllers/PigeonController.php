<?php

namespace App\Http\Controllers;

use App\Http\Requests\PigeonStoreRequest;
use App\Repositories\PigeonImageRepository;
use App\Repositories\PigeonRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PigeonController extends Controller
{
    public function __construct(
        public readonly PigeonRepository      $pigeonRepository,
        public readonly PigeonImageRepository $pigeonImageRepository,
    )
    {
    }

    public function store(PigeonStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $path = public_path('images');
        try {
            DB::beginTransaction();
            $result = $this->pigeonRepository->store($data);
            foreach ($request->file('images') as $file) {
                $imageName = sprintf('%s-%s.%s', time(), rand(100, 999), $file->extension());
                $file->move($path, $imageName);
                $this->pigeonImageRepository->store([
                    'pigeon_id' => $result->id,
                    'path' => sprintf('%s/%s', 'images', $imageName),
                    'family_tree' => false,
                ]);
            }
            $familyTreeImage = $request->file('family_tree_image');
            $familyTreeImageName = sprintf('%s-%s.%s', time(), rand(100, 999), $familyTreeImage->extension());
            $familyTreeImage->move($path, $familyTreeImageName);
            $this->pigeonImageRepository->store([
                'pigeon_id' => $result->id,
                'path' => sprintf('%s/%s', 'images', $familyTreeImageName),
                'family_tree' => true,
            ]);
            DB::commit();
            return response()->json($result,201);
        } catch (Exception $exception) {
            Log::error('pigeon.store', ['message' => $exception->getMessage()]);
            DB::rollBack();
            return response()->json(['message' => 'system errors.'], 500);
        }
    }
}
