<?php

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\TrackRecord;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{actingAs, getJson, postJson, patchJson, deleteJson};

uses(RefreshDatabase::class);

beforeEach(function () {
    ArticleCategory::create([
        'slug' => 'kabar-kegiatan-desa',
        'name' => json_encode(['id' => 'Kabar & Kegiatan Desa', 'en' => 'Village News & Activities']),
    ]);
});

// Helper: create a published article
function createPublishedArticle(): Article
{
    return Article::create([
        'category_id' => 1,
        'user_id' => User::factory()->create(['role' => 'admin'])->id,
        'title' => ['id' => 'Judul Artikel', 'en' => 'Article Title'],
        'content' => ['id' => 'Isi artikel...', 'en' => 'Article content...'],
        'date' => now(),
        'status' => 'published',
        'published_at' => now(),
    ]);
}

// Helper: create a draft article
function createDraftArticle(): Article
{
    return Article::create([
        'category_id' => 1,
        'user_id' => User::factory()->create(['role' => 'admin'])->id,
        'title' => ['id' => 'Draft Judul', 'en' => ''],
        'content' => ['id' => 'Draft isi...', 'en' => ''],
        'date' => now(),
        'status' => 'draft',
    ]);
}

// Public only sees published
test('public index only returns published articles', function () {
    $published = createPublishedArticle();
    $draft = createDraftArticle();

    $response = getJson('/api/articles');

    $response->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.id', $published->id);
});

test('public cannot see draft article by id', function () {
    $draft = createDraftArticle();

    $response = getJson("/api/articles/{$draft->id}");

    $response->assertNotFound();
});

test('public can see published article by id', function () {
    $published = createPublishedArticle();

    $response = getJson("/api/articles/{$published->id}");

    $response->assertOk()
        ->assertJsonPath('data.id', $published->id);
});

// Admin can see drafts
test('authenticated admin sees all articles including drafts', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $published = createPublishedArticle();
    $draft = createDraftArticle();

    $response = actingAs($admin, 'web')->getJson('/api/articles');

    $response->assertOk()
        ->assertJsonCount(2, 'data');
});

// Draft workflow
test('store creates article as draft by default', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = actingAs($admin, 'web')->postJson('/api/articles', [
        'category_id' => 1,
        'title' => ['id' => 'Artikel Baru', 'en' => ''],
        'content' => ['id' => 'Isi baru...', 'en' => ''],
        'date' => today()->toDateString(),
        'status' => 'draft',
    ]);

    $response->assertCreated()
        ->assertJsonPath('data.id', fn ($val) => ! is_null($val));
});

// Publish requires both languages
test('cannot publish article with missing english', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $article = createDraftArticle();

    $response = actingAs($admin, 'web')->postJson("/api/articles/{$article->id}/publish");

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['content.en', 'title.en']);
});

test('can publish article with both languages filled', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $article = Article::create([
        'category_id' => 1,
        'user_id' => $admin->id,
        'title' => ['id' => 'Judul', 'en' => 'Title'],
        'content' => ['id' => 'Isi', 'en' => 'Content'],
        'date' => now(),
        'status' => 'draft',
    ]);

    $response = actingAs($admin, 'web')->postJson("/api/articles/{$article->id}/publish");

    $response->assertOk()
        ->assertJsonPath('data.status', 'published');
});

// Unpublish
test('can unpublish a published article', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $article = createPublishedArticle();

    $response = actingAs($admin, 'web')->postJson("/api/articles/{$article->id}/unpublish");

    $response->assertOk()
        ->assertJsonPath('data.status', 'draft')
        ->assertJsonPath('data.published_at', null);
});

// Soft delete
test('delete performs soft delete', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $article = createPublishedArticle();

    actingAs($admin, 'web')->deleteJson("/api/articles/{$article->id}")->assertOk();

    // Not in public index
    expect(getJson('/api/articles')->json('data'))->toHaveCount(0);

    // Still exists in database
    expect(Article::withTrashed()->find($article->id))->not->toBeNull();
});
