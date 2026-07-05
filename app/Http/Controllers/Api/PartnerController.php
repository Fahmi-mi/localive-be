<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\HandlesPublishActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\Content\StorePartnerRequest;
use App\Http\Requests\Content\UpdatePartnerRequest;
use App\Http\Resources\PartnerResource;
use App\Models\Partner;
use App\Services\ImagePipelineService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PartnerController extends Controller
{
    use HandlesPublishActions;

    protected string $model = Partner::class;
    protected string $resource = PartnerResource::class;

    public function index(): AnonymousResourceCollection
    {
        $partners = Partner::orderBy('created_at', 'desc')->get();

        return PartnerResource::collection($partners);
    }

    public function store(StorePartnerRequest $request, ImagePipelineService $pipeline): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $data['logo'] = $pipeline->process($request->file('logo'), 'partners');
        }

        $partner = Partner::create($data);

        return response()->json([
            'message' => 'Mitra berhasil dibuat.',
            'data' => new PartnerResource($partner),
        ], 201);
    }

    public function show(Partner $partner): PartnerResource
    {
        return new PartnerResource($partner);
    }

    public function update(
        UpdatePartnerRequest $request,
        Partner $partner,
        ImagePipelineService $pipeline,
    ): JsonResponse {
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $data['logo'] = $pipeline->replace(
                $request->file('logo'),
                'partners',
                $partner->logo,
            );
        }

        $partner->update($data);

        return response()->json([
            'message' => 'Mitra berhasil diperbarui.',
            'data' => new PartnerResource($partner->fresh()),
        ]);
    }

    public function destroy(Partner $partner): JsonResponse
    {
        $partner->delete();

        return response()->json([
            'message' => 'Mitra berhasil dihapus.',
        ]);
    }
}
