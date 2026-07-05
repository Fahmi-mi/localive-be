<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\HandlesPublishActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\Content\StoreOrganizationMemberRequest;
use App\Http\Requests\Content\UpdateOrganizationMemberRequest;
use App\Http\Resources\OrganizationMemberResource;
use App\Models\OrganizationMember;
use App\Services\ImagePipelineService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrganizationMemberController extends Controller
{
    use HandlesPublishActions;

    protected string $model = OrganizationMember::class;
    protected string $resource = OrganizationMemberResource::class;

    public function index(): AnonymousResourceCollection
    {
        $members = OrganizationMember::orderBy('created_at', 'desc')->get();

        return OrganizationMemberResource::collection($members);
    }

    public function store(StoreOrganizationMemberRequest $request, ImagePipelineService $pipeline): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $pipeline->process($request->file('image'), 'organization');
        }

        $member = OrganizationMember::create($data);

        return response()->json([
            'message' => 'Pengurus organisasi berhasil dibuat.',
            'data' => new OrganizationMemberResource($member),
        ], 201);
    }

    public function show(OrganizationMember $organizationMember): OrganizationMemberResource
    {
        return new OrganizationMemberResource($organizationMember);
    }

    public function update(
        UpdateOrganizationMemberRequest $request,
        OrganizationMember $organizationMember,
        ImagePipelineService $pipeline,
    ): JsonResponse {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $pipeline->replace(
                $request->file('image'),
                'organization',
                $organizationMember->image,
            );
        }

        $organizationMember->update($data);

        return response()->json([
            'message' => 'Pengurus organisasi berhasil diperbarui.',
            'data' => new OrganizationMemberResource($organizationMember->fresh()),
        ]);
    }

    public function destroy(OrganizationMember $organizationMember): JsonResponse
    {
        $organizationMember->delete();

        return response()->json([
            'message' => 'Pengurus organisasi berhasil dihapus.',
        ]);
    }
}
