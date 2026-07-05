<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\HandlesPublishActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\Content\StoreWhatsappNumberRequest;
use App\Http\Requests\Content\UpdateWhatsappNumberRequest;
use App\Http\Resources\WhatsappNumberResource;
use App\Models\WhatsappNumber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class WhatsappNumberController extends Controller
{
    use HandlesPublishActions;

    protected string $model = WhatsappNumber::class;
    protected string $resource = WhatsappNumberResource::class;

    public function index(): AnonymousResourceCollection
    {
        $numbers = WhatsappNumber::orderBy('created_at', 'desc')->get();

        return WhatsappNumberResource::collection($numbers);
    }

    public function store(StoreWhatsappNumberRequest $request): JsonResponse
    {
        $number = WhatsappNumber::create($request->validated());

        return response()->json([
            'message' => 'Nomor WhatsApp berhasil dibuat.',
            'data' => new WhatsappNumberResource($number),
        ], 201);
    }

    public function show(WhatsappNumber $whatsappNumber): WhatsappNumberResource
    {
        return new WhatsappNumberResource($whatsappNumber);
    }

    public function update(UpdateWhatsappNumberRequest $request, WhatsappNumber $whatsappNumber): JsonResponse
    {
        $whatsappNumber->update($request->validated());

        return response()->json([
            'message' => 'Nomor WhatsApp berhasil diperbarui.',
            'data' => new WhatsappNumberResource($whatsappNumber->fresh()),
        ]);
    }

    public function destroy(WhatsappNumber $whatsappNumber): JsonResponse
    {
        $whatsappNumber->delete();

        return response()->json([
            'message' => 'Nomor WhatsApp berhasil dihapus.',
        ]);
    }
}
