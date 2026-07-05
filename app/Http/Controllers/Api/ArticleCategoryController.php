<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreArticleCategoryRequest;
use App\Http\Requests\Category\UpdateArticleCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\ArticleCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ArticleCategoryController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $categories = ArticleCategory::orderBy('created_at')->get();

        return CategoryResource::collection($categories);
    }

    public function store(StoreArticleCategoryRequest $request): JsonResponse
    {
        $category = ArticleCategory::create($request->validated());

        return response()->json([
            'message' => 'Kategori artikel berhasil dibuat.',
            'data' => new CategoryResource($category),
        ], 201);
    }

    public function update(UpdateArticleCategoryRequest $request, ArticleCategory $articleCategory): JsonResponse
    {
        $articleCategory->update($request->validated());

        return response()->json([
            'message' => 'Kategori artikel berhasil diperbarui.',
            'data' => new CategoryResource($articleCategory->fresh()),
        ]);
    }

    public function destroy(ArticleCategory $articleCategory): JsonResponse
    {
        $articleCategory->delete();

        return response()->json([
            'message' => 'Kategori artikel berhasil dihapus.',
        ]);
    }
}
