<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\HandlesPublishActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\Content\StoreTrackRecordRequest;
use App\Http\Requests\Content\UpdateTrackRecordRequest;
use App\Http\Resources\TrackRecordResource;
use App\Models\TrackRecord;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TrackRecordController extends Controller
{
    use HandlesPublishActions;

    protected string $model = TrackRecord::class;
    protected string $resource = TrackRecordResource::class;

    public function index(): AnonymousResourceCollection
    {
        $records = TrackRecord::orderBy('created_at', 'desc')->get();

        return TrackRecordResource::collection($records);
    }

    public function store(StoreTrackRecordRequest $request): JsonResponse
    {
        $record = TrackRecord::create($request->validated());

        return response()->json([
            'message' => 'Track record berhasil dibuat.',
            'data' => new TrackRecordResource($record),
        ], 201);
    }

    public function show(TrackRecord $trackRecord): TrackRecordResource
    {
        return new TrackRecordResource($trackRecord);
    }

    public function update(UpdateTrackRecordRequest $request, TrackRecord $trackRecord): JsonResponse
    {
        $trackRecord->update($request->validated());

        return response()->json([
            'message' => 'Track record berhasil diperbarui.',
            'data' => new TrackRecordResource($trackRecord->fresh()),
        ]);
    }

    public function destroy(TrackRecord $trackRecord): JsonResponse
    {
        $trackRecord->delete();

        return response()->json([
            'message' => 'Track record berhasil dihapus.',
        ]);
    }
}
