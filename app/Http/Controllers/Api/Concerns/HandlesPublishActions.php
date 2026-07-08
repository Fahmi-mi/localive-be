<?php

namespace App\Http\Controllers\Api\Concerns;

use App\Models\Scopes\PublishedScope;
use Illuminate\Http\JsonResponse;

trait HandlesPublishActions
{
    public function publish(int $id): JsonResponse
    {
        $model = $this->model::withoutGlobalScope(PublishedScope::class)->findOrFail($id);
        $model->validateForPublish();
        $model->publish();

        return response()->json([
            'message' => 'Konten berhasil dipublikasikan.',
            'data' => new $this->resource($model->fresh()),
        ]);
    }

    public function unpublish(int $id): JsonResponse
    {
        $model = $this->model::withoutGlobalScope(PublishedScope::class)->findOrFail($id);
        $model->unpublish();

        return response()->json([
            'message' => 'Konten berhasil disembunyikan.',
            'data' => new $this->resource($model->fresh()),
        ]);
    }
}
