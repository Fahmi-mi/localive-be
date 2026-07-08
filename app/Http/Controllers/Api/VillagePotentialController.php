<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\HandlesPublishActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\Content\StoreVillagePotentialRequest;
use App\Http\Requests\Content\UpdateVillagePotentialRequest;
use App\Http\Resources\VillagePotentialResource;
use App\Models\VillagePotential;
use App\Services\ImagePipelineService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class VillagePotentialController extends Controller
{
    use HandlesPublishActions;

    protected string $model = VillagePotential::class;
    protected string $resource = VillagePotentialResource::class;

    public function index(): AnonymousResourceCollection
    {
        $potentials = VillagePotential::orderBy('created_at', 'desc')->get();

        return VillagePotentialResource::collection($potentials);
    }

    public function store(StoreVillagePotentialRequest $request, ImagePipelineService $pipeline): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $pipeline->process($request->file('image'), 'village-potentials');
        }

        $potential = VillagePotential::create($data);

        return response()->json([
            'message' => 'Potensi desa berhasil dibuat.',
            'data' => new VillagePotentialResource($potential),
        ], 201);
    }

    public function show(VillagePotential $villagePotential): VillagePotentialResource
    {
        return new VillagePotentialResource($villagePotential);
    }

    public function update(
        UpdateVillagePotentialRequest $request,
        VillagePotential $villagePotential,
        ImagePipelineService $pipeline,
    ): JsonResponse {
        $data = $request->validated();

        if ($request->boolean('remove_image') && $villagePotential->image) {
            $pipeline->delete($villagePotential->image);
            $data['image'] = null;
        }

        if ($request->hasFile('image')) {
            $data['image'] = $pipeline->replace(
                $request->file('image'),
                'village-potentials',
                $villagePotential->image,
            );
        }

        $villagePotential->update($data);

        return response()->json([
            'message' => 'Potensi desa berhasil diperbarui.',
            'data' => new VillagePotentialResource($villagePotential->fresh()),
        ]);
    }

    public function destroy(VillagePotential $villagePotential): JsonResponse
    {
        $villagePotential->delete();

        return response()->json([
            'message' => 'Potensi desa berhasil dihapus.',
        ]);
    }
}
