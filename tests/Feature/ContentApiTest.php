<?php

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\OrganizationMember;
use App\Models\Partner;
use App\Models\TourCategory;
use App\Models\TourPackage;
use App\Models\TrackRecord;
use App\Models\Umkm;
use App\Models\UmkmCategory;
use App\Models\User;
use App\Models\VillagePotential;
use App\Models\WhatsappNumber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{actingAs, getJson};

uses(RefreshDatabase::class);

// Response Structure
test('article response has expected translatable structure', function () {
    ArticleCategory::create(['slug' => 'news', 'name' => ['id' => 'Berita', 'en' => 'News']]);
    $user = User::factory()->create(['role' => 'admin']);
    $article = Article::create([
        'category_id' => 1,
        'user_id' => $user->id,
        'title' => ['id' => 'Judul', 'en' => 'Title'],
        'content' => ['id' => 'Isi', 'en' => 'Content'],
        'date' => now(),
        'image' => 'articles/test.webp',
        'status' => 'published',
        'published_at' => now(),
    ]);

    $response = getJson("/api/articles/{$article->id}");

    $response->assertOk()
        ->assertJsonPath('data.title.id', 'Judul')
        ->assertJsonPath('data.title.en', 'Title')
        ->assertJsonPath('data.content.id', 'Isi')
        ->assertJsonPath('data.content.en', 'Content')
        ->assertJsonPath('data.status', 'published')
        ->assertJsonPath('data.slug', fn ($slug) => ! is_null($slug))
        ->assertJsonPath('data.image_url', fn ($url) => str_contains($url, 'storage/articles/test.webp'));
});

test('partner response has logo_url', function () {
    $partner = Partner::create([
        'name' => ['id' => 'Mitra A', 'en' => 'Partner A'],
        'logo' => 'partners/logo.webp',
        'status' => 'published',
        'published_at' => now(),
    ]);

    $response = getJson("/api/partners/{$partner->id}");

    $response->assertOk()
        ->assertJsonPath('data.name.id', 'Mitra A')
        ->assertJsonPath('data.logo_url', fn ($url) => str_contains($url, 'storage/partners/logo.webp'));
});

test('track record response has content translatable', function () {
    $record = TrackRecord::create([
        'content' => ['id' => 'Prestasi 2024', 'en' => 'Achievement 2024'],
        'status' => 'published',
        'published_at' => now(),
    ]);

    $response = getJson("/api/track-records/{$record->id}");

    $response->assertOk()
        ->assertJsonPath('data.content.id', 'Prestasi 2024')
        ->assertJsonPath('data.content.en', 'Achievement 2024');
});

test('whatsapp number response has number and label', function () {
    $wa = WhatsappNumber::create([
        'number' => '6281234567890',
        'label' => ['id' => 'Admin Desa', 'en' => 'Village Admin'],
        'status' => 'published',
        'published_at' => now(),
    ]);

    $response = getJson("/api/whatsapp-numbers/{$wa->id}");

    $response->assertOk()
        ->assertJsonPath('data.number', '6281234567890')
        ->assertJsonPath('data.label.id', 'Admin Desa');
});

test('organization member response has name translatable', function () {
    $member = OrganizationMember::create([
        'name' => ['id' => 'Pak Budi', 'en' => 'Mr. Budi'],
        'status' => 'published',
        'published_at' => now(),
    ]);

    $response = getJson("/api/organization-members/{$member->id}");

    $response->assertOk()
        ->assertJsonPath('data.name.id', 'Pak Budi')
        ->assertJsonPath('data.name.en', 'Mr. Budi');
});

test('tour package response includes category', function () {
    TourCategory::create(['slug' => 'destinasi', 'name' => ['id' => 'Destinasi', 'en' => 'Destination']]);
    $pkg = TourPackage::create([
        'category_id' => 1,
        'title' => ['id' => 'Pantai Indah', 'en' => 'Beautiful Beach'],
        'description' => ['id' => 'Deskripsi...', 'en' => 'Description...'],
        'status' => 'published',
        'published_at' => now(),
    ]);

    $response = getJson("/api/tour-packages/{$pkg->id}");

    $response->assertOk()
        ->assertJsonPath('data.category.slug', 'destinasi');
});

test('umkm response includes maps_link', function () {
    UmkmCategory::create(['slug' => 'makanan', 'name' => ['id' => 'Makanan', 'en' => 'Culinary']]);
    $umkm = Umkm::create([
        'category_id' => 1,
        'title' => ['id' => 'Toko A', 'en' => 'Shop A'],
        'maps_link' => 'https://maps.google.com/xyz',
        'status' => 'published',
        'published_at' => now(),
    ]);

    $response = getJson("/api/umkm/{$umkm->id}");

    $response->assertOk()
        ->assertJsonPath('data.maps_link', 'https://maps.google.com/xyz');
});

test('village potential response has title and description', function () {
    $potential = VillagePotential::create([
        'title' => ['id' => 'Pertanian', 'en' => 'Agriculture'],
        'description' => ['id' => 'Deskripsi pertanian', 'en' => 'Agriculture description'],
        'status' => 'published',
        'published_at' => now(),
    ]);

    $response = getJson("/api/village-potentials/{$potential->id}");

    $response->assertOk()
        ->assertJsonPath('data.title.id', 'Pertanian')
        ->assertJsonPath('data.description.en', 'Agriculture description');
});

test('category responses have translatable name', function () {
    ArticleCategory::create(['slug' => 'news', 'name' => ['id' => 'Berita', 'en' => 'News']]);

    $response = getJson('/api/article-categories');

    $response->assertOk()
        ->assertJsonPath('data.0.name.id', 'Berita')
        ->assertJsonPath('data.0.name.en', 'News')
        ->assertJsonPath('data.0.slug', 'news');
});
