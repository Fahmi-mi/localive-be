<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreTourCategoryRequest;
use App\Http\Requests\Category\UpdateTourCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\TourCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TourCategoryController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $categories = TourCategory::orderBy('created_at')->get();

        return CategoryResource::collection($categories);
    }

    public function store(StoreTourCategoryRequest $request): JsonResponse
    {
        $category = TourCategory::create($request->validated());

        return response()->json([
            'message' => 'Kategori wisata berhasil dibuat.',
            'data' => new CategoryResource($category),
        ], 201);
    }

    public function update(UpdateTourCategoryRequest $request, TourCategory $tourCategory): JsonResponse
    {
        $tourCategory->update($request->validated());

        return response()->json([
            'message' => 'Kategori wisata berhasil diperbarui.',
            'data' => new CategoryResource($tourCategory->fresh()),
        ]);
    }

    public function destroy(TourCategory $tourCategory): JsonResponse
    {
        $tourCategory->delete();

        return response()->json([
            'message' => 'Kategori wisata berhasil dihapus.',
        ]);
    }
}
