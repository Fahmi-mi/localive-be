<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Content\UpdateProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use App\Models\Scopes\PublishedScope;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    public function show(): ProfileResource
    {
        return new ProfileResource(Profile::singleton());
    }

    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $profile = Profile::singleton();
        $profile->update($request->validated());

        return response()->json([
            'message' => 'Profil desa berhasil diperbarui.',
            'data' => new ProfileResource($profile->fresh()),
        ]);
    }

    public function publish(): JsonResponse
    {
        $profile = Profile::withoutGlobalScope(PublishedScope::class)->firstOrFail();
        $profile->validateForPublish();
        $profile->publish();

        return response()->json([
            'message' => 'Profil desa berhasil dipublikasikan.',
            'data' => new ProfileResource($profile->fresh()),
        ]);
    }

    public function unpublish(): JsonResponse
    {
        $profile = Profile::withoutGlobalScope(PublishedScope::class)->firstOrFail();
        $profile->unpublish();

        return response()->json([
            'message' => 'Profil desa berhasil disembunyikan.',
            'data' => new ProfileResource($profile->fresh()),
        ]);
    }
}
