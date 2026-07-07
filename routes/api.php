<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\ArticleCategoryController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrganizationMemberController;
use App\Http\Controllers\Api\PartnerController;
use App\Http\Controllers\Api\PasswordController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\TourCategoryController;
use App\Http\Controllers\Api\TourPackageController;
use App\Http\Controllers\Api\TrackRecordController;
use App\Http\Controllers\Api\UmkmCategoryController;
use App\Http\Controllers\Api\UmkmController;
use App\Http\Controllers\Api\VillageInfoController;
use App\Http\Controllers\Api\VillagePotentialController;
use App\Http\Controllers\Api\WhatsappNumberController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/forgot-password', [PasswordController::class, 'forgotPassword'])->name('forgot-password');

Route::get('/article-categories', [ArticleCategoryController::class, 'index'])->name('article-categories.index');
Route::get('/umkm-categories', [UmkmCategoryController::class, 'index'])->name('umkm-categories.index');
Route::get('/tour-categories', [TourCategoryController::class, 'index'])->name('tour-categories.index');

Route::get('/track-records', [TrackRecordController::class, 'index'])->name('track-records.index');
Route::get('/track-records/{track_record}', [TrackRecordController::class, 'show'])->name('track-records.show');
Route::get('/whatsapp-numbers', [WhatsappNumberController::class, 'index'])->name('whatsapp-numbers.index');
Route::get('/whatsapp-numbers/{whatsapp_number}', [WhatsappNumberController::class, 'show'])->name('whatsapp-numbers.show');
Route::get('/organization-members', [OrganizationMemberController::class, 'index'])->name('organization-members.index');
Route::get('/organization-members/{organization_member}', [OrganizationMemberController::class, 'show'])->name('organization-members.show');
Route::get('/partners', [PartnerController::class, 'index'])->name('partners.index');
Route::get('/partners/{partner}', [PartnerController::class, 'show'])->name('partners.show');
Route::get('/village-potentials', [VillagePotentialController::class, 'index'])->name('village-potentials.index');
Route::get('/village-potentials/{village_potential}', [VillagePotentialController::class, 'show'])->name('village-potentials.show');
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/umkm', [UmkmController::class, 'index'])->name('umkm.index');
Route::get('/umkm/{umkm}', [UmkmController::class, 'show'])->name('umkm.show');
Route::get('/tour-packages', [TourPackageController::class, 'index'])->name('tour-packages.index');
Route::get('/tour-packages/{tour_package}', [TourPackageController::class, 'show'])->name('tour-packages.show');
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/village-info', [VillageInfoController::class, 'show'])->name('village-info.show');

// Authenticated
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', function (Request $request) {
        return response()->json(['data' => new UserResource($request->user())]);
    })->name('me');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/change-password', [PasswordController::class, 'changePassword'])->name('change-password');

    // Categories
    Route::apiResource('/article-categories', ArticleCategoryController::class)->only(['store', 'update', 'destroy']);
    Route::apiResource('/umkm-categories', UmkmCategoryController::class)->only(['store', 'update', 'destroy']);
    Route::apiResource('/tour-categories', TourCategoryController::class)->only(['store', 'update', 'destroy']);

    // Track Records
    Route::apiResource('/track-records', TrackRecordController::class)->except(['index', 'show']);
    Route::post('/track-records/{id}/publish', [TrackRecordController::class, 'publish'])->name('track-records.publish');
    Route::post('/track-records/{id}/unpublish', [TrackRecordController::class, 'unpublish'])->name('track-records.unpublish');

    // WhatsApp Numbers
    Route::apiResource('/whatsapp-numbers', WhatsappNumberController::class)->except(['index', 'show']);
    Route::post('/whatsapp-numbers/{id}/publish', [WhatsappNumberController::class, 'publish'])->name('whatsapp-numbers.publish');
    Route::post('/whatsapp-numbers/{id}/unpublish', [WhatsappNumberController::class, 'unpublish'])->name('whatsapp-numbers.unpublish');

    // Organization Members
    Route::apiResource('/organization-members', OrganizationMemberController::class)->except(['index', 'show']);
    Route::post('/organization-members/{id}/publish', [OrganizationMemberController::class, 'publish'])->name('organization-members.publish');
    Route::post('/organization-members/{id}/unpublish', [OrganizationMemberController::class, 'unpublish'])->name('organization-members.unpublish');

    // Partners
    Route::apiResource('/partners', PartnerController::class)->except(['index', 'show']);
    Route::post('/partners/{id}/publish', [PartnerController::class, 'publish'])->name('partners.publish');
    Route::post('/partners/{id}/unpublish', [PartnerController::class, 'unpublish'])->name('partners.unpublish');

    // Village Potentials
    Route::apiResource('/village-potentials', VillagePotentialController::class)->except(['index', 'show']);
    Route::post('/village-potentials/{id}/publish', [VillagePotentialController::class, 'publish'])->name('village-potentials.publish');
    Route::post('/village-potentials/{id}/unpublish', [VillagePotentialController::class, 'unpublish'])->name('village-potentials.unpublish');

    // Articles
    Route::apiResource('/articles', ArticleController::class)->except(['index', 'show']);
    Route::post('/articles/{id}/publish', [ArticleController::class, 'publish'])->name('articles.publish');
    Route::post('/articles/{id}/unpublish', [ArticleController::class, 'unpublish'])->name('articles.unpublish');

    // UMKM
    Route::apiResource('/umkm', UmkmController::class)->except(['index', 'show']);
    Route::post('/umkm/{id}/publish', [UmkmController::class, 'publish'])->name('umkm.publish');
    Route::post('/umkm/{id}/unpublish', [UmkmController::class, 'unpublish'])->name('umkm.unpublish');

    // Tour Packages
    Route::apiResource('/tour-packages', TourPackageController::class)->except(['index', 'show']);
    Route::post('/tour-packages/{id}/publish', [TourPackageController::class, 'publish'])->name('tour-packages.publish');
    Route::post('/tour-packages/{id}/unpublish', [TourPackageController::class, 'unpublish'])->name('tour-packages.unpublish');

    // Singletons
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/publish', [ProfileController::class, 'publish'])->name('profile.publish');
    Route::post('/profile/unpublish', [ProfileController::class, 'unpublish'])->name('profile.unpublish');

    Route::patch('/village-info', [VillageInfoController::class, 'update'])->name('village-info.update');
    Route::post('/village-info/publish', [VillageInfoController::class, 'publish'])->name('village-info.publish');
    Route::post('/village-info/unpublish', [VillageInfoController::class, 'unpublish'])->name('village-info.unpublish');

    // Super Admin only
    Route::middleware('role:super_admin')->group(function () {
        Route::apiResource('/admins', AdminController::class)->except(['show']);
    });
});
