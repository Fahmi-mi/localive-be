<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\HandlesPublishActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\Content\StoreArticleRequest;
use App\Http\Requests\Content\UpdateArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Services\ImagePipelineService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ArticleController extends Controller
{
    use HandlesPublishActions;

    protected string $model = Article::class;
    protected string $resource = ArticleResource::class;

    public function index(): AnonymousResourceCollection
    {
        $articles = Article::with(['category', 'author'])
            ->orderBy('created_at', 'desc')
            ->get();

        return ArticleResource::collection($articles);
    }

    public function store(StoreArticleRequest $request, ImagePipelineService $pipeline): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        if ($request->hasFile('image')) {
            $data['image'] = $pipeline->process($request->file('image'), 'articles');
        }

        $article = Article::create($data);

        return response()->json([
            'message' => 'Artikel berhasil dibuat.',
            'data' => new ArticleResource($article->load(['category', 'author'])),
        ], 201);
    }

    public function show(Article $article): ArticleResource
    {
        return new ArticleResource($article->load(['category', 'author']));
    }

    public function update(
        UpdateArticleRequest $request,
        Article $article,
        ImagePipelineService $pipeline,
    ): JsonResponse {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $pipeline->replace(
                $request->file('image'),
                'articles',
                $article->image,
            );
        }

        $article->update($data);

        return response()->json([
            'message' => 'Artikel berhasil diperbarui.',
            'data' => new ArticleResource($article->fresh()->load(['category', 'author'])),
        ]);
    }

    public function destroy(Article $article): JsonResponse
    {
        $article->delete();

        return response()->json([
            'message' => 'Artikel berhasil dihapus.',
        ]);
    }
}
