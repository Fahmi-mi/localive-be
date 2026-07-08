<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreUmkmCategoryRequest;
use App\Http\Requests\Category\UpdateUmkmCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\UmkmCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UmkmCategoryController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $categories = UmkmCategory::orderBy('created_at')->get();

        return CategoryResource::collection($categories);
    }

    public function store(StoreUmkmCategoryRequest $request): JsonResponse
    {
        $category = UmkmCategory::create($request->validated());

        return response()->json([
            'message' => 'Kategori UMKM berhasil dibuat.',
            'data' => new CategoryResource($category),
        ], 201);
    }

    public function update(UpdateUmkmCategoryRequest $request, UmkmCategory $umkmCategory): JsonResponse
    {
        $umkmCategory->update($request->validated());

        return response()->json([
            'message' => 'Kategori UMKM berhasil diperbarui.',
            'data' => new CategoryResource($umkmCategory->fresh()),
        ]);
    }

    public function destroy(UmkmCategory $umkmCategory): JsonResponse
    {
        $umkmCategory->delete();

        return response()->json([
            'message' => 'Kategori UMKM berhasil dihapus.',
        ]);
    }
}
