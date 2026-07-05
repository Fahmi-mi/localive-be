<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Content\UpdateVillageInfoRequest;
use App\Http\Resources\VillageInfoResource;
use App\Models\Scopes\PublishedScope;
use App\Models\VillageInfo;
use Illuminate\Http\JsonResponse;

class VillageInfoController extends Controller
{
    public function show(): VillageInfoResource
    {
        return new VillageInfoResource(VillageInfo::singleton());
    }

    public function update(UpdateVillageInfoRequest $request): JsonResponse
    {
        $info = VillageInfo::singleton();
        $info->update($request->validated());

        return response()->json([
            'message' => 'Visi misi desa berhasil diperbarui.',
            'data' => new VillageInfoResource($info->fresh()),
        ]);
    }

    public function publish(): JsonResponse
    {
        $info = VillageInfo::withoutGlobalScope(PublishedScope::class)->firstOrFail();
        $info->validateForPublish();
        $info->publish();

        return response()->json([
            'message' => 'Visi misi desa berhasil dipublikasikan.',
            'data' => new VillageInfoResource($info->fresh()),
        ]);
    }

    public function unpublish(): JsonResponse
    {
        $info = VillageInfo::withoutGlobalScope(PublishedScope::class)->firstOrFail();
        $info->unpublish();

        return response()->json([
            'message' => 'Visi misi desa berhasil disembunyikan.',
            'data' => new VillageInfoResource($info->fresh()),
        ]);
    }
}
