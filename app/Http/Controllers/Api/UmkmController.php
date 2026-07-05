<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\HandlesPublishActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\Content\StoreUmkmRequest;
use App\Http\Requests\Content\UpdateUmkmRequest;
use App\Http\Resources\UmkmResource;
use App\Models\Umkm;
use App\Services\ImagePipelineService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UmkmController extends Controller
{
    use HandlesPublishActions;

    protected string $model = Umkm::class;
    protected string $resource = UmkmResource::class;

    public function index(): AnonymousResourceCollection
    {
        $umkm = Umkm::with('category')
            ->orderBy('created_at', 'desc')
            ->get();

        return UmkmResource::collection($umkm);
    }

    public function store(StoreUmkmRequest $request, ImagePipelineService $pipeline): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $pipeline->process($request->file('image'), 'umkm');
        }

        $umkm = Umkm::create($data);

        return response()->json([
            'message' => 'UMKM berhasil dibuat.',
            'data' => new UmkmResource($umkm->load('category')),
        ], 201);
    }

    public function show(Umkm $umkm): UmkmResource
    {
        return new UmkmResource($umkm->load('category'));
    }

    public function update(
        UpdateUmkmRequest $request,
        Umkm $umkm,
        ImagePipelineService $pipeline,
    ): JsonResponse {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $pipeline->replace(
                $request->file('image'),
                'umkm',
                $umkm->image,
            );
        }

        $umkm->update($data);

        return response()->json([
            'message' => 'UMKM berhasil diperbarui.',
            'data' => new UmkmResource($umkm->fresh()->load('category')),
        ]);
    }

    public function destroy(Umkm $umkm): JsonResponse
    {
        $umkm->delete();

        return response()->json([
            'message' => 'UMKM berhasil dihapus.',
        ]);
    }
}
