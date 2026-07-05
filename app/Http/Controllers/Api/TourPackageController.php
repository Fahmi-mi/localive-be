<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\HandlesPublishActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\Content\StoreTourPackageRequest;
use App\Http\Requests\Content\UpdateTourPackageRequest;
use App\Http\Resources\TourPackageResource;
use App\Models\TourPackage;
use App\Services\ImagePipelineService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TourPackageController extends Controller
{
    use HandlesPublishActions;

    protected string $model = TourPackage::class;
    protected string $resource = TourPackageResource::class;

    public function index(Request $request): AnonymousResourceCollection
    {
        $query = TourPackage::with('category');

        if ($request->has('category')) {
            $query->byCategory($request->get('category'));
        }

        return TourPackageResource::collection(
            $query->orderBy('created_at', 'desc')->get(),
        );
    }

    public function store(StoreTourPackageRequest $request, ImagePipelineService $pipeline): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $pipeline->process($request->file('image'), 'tour-packages');
        }

        $tourPackage = TourPackage::create($data);

        return response()->json([
            'message' => 'Paket wisata berhasil dibuat.',
            'data' => new TourPackageResource($tourPackage->load('category')),
        ], 201);
    }

    public function show(TourPackage $tourPackage): TourPackageResource
    {
        return new TourPackageResource($tourPackage->load('category'));
    }

    public function update(
        UpdateTourPackageRequest $request,
        TourPackage $tourPackage,
        ImagePipelineService $pipeline,
    ): JsonResponse {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $pipeline->replace(
                $request->file('image'),
                'tour-packages',
                $tourPackage->image,
            );
        }

        $tourPackage->update($data);

        return response()->json([
            'message' => 'Paket wisata berhasil diperbarui.',
            'data' => new TourPackageResource($tourPackage->fresh()->load('category')),
        ]);
    }

    public function destroy(TourPackage $tourPackage): JsonResponse
    {
        $tourPackage->delete();

        return response()->json([
            'message' => 'Paket wisata berhasil dihapus.',
        ]);
    }
}
