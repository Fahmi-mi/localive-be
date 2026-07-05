<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\ArticleCategoryController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrganizationMemberController;
use App\Http\Controllers\Api\PartnerController;
use App\Http\Controllers\Api\PasswordController;
use App\Http\Controllers\Api\TourCategoryController;
use App\Http\Controllers\Api\TourPackageController;
use App\Http\Controllers\Api\TrackRecordController;
use App\Http\Controllers\Api\UmkmCategoryController;
use App\Http\Controllers\Api\UmkmController;
use App\Http\Controllers\Api\VillagePotentialController;
use App\Http\Controllers\Api\WhatsappNumberController;
use Illuminate\Support\Facades\Route;

// Public routes (no authentication)
Route::post("/login", [AuthController::class, "login"]);
Route::post("/forgot-password", [PasswordController::class, "forgotPassword"]);
Route::get("/article-categories", [ArticleCategoryController::class, "index"]);
Route::get("/umkm-categories", [UmkmCategoryController::class, "index"]);
Route::get("/tour-categories", [TourCategoryController::class, "index"]);
Route::get("/track-records", [TrackRecordController::class, "index"]);
Route::get("/track-records/{track_record}", [
    TrackRecordController::class,
    "show",
]);
Route::get("/whatsapp-numbers", [WhatsappNumberController::class, "index"]);
Route::get("/whatsapp-numbers/{whatsapp_number}", [
    WhatsappNumberController::class,
    "show",
]);
Route::get("/organization-members", [
    OrganizationMemberController::class,
    "index",
]);
Route::get("/organization-members/{organization_member}", [
    OrganizationMemberController::class,
    "show",
]);
Route::get("/partners", [PartnerController::class, "index"]);
Route::get("/partners/{partner}", [PartnerController::class, "show"]);
Route::get("/village-potentials", [VillagePotentialController::class, "index"]);
Route::get("/village-potentials/{village_potential}", [
    VillagePotentialController::class,
    "show",
]);
Route::get("/articles", [ArticleController::class, "index"]);
Route::get("/articles/{article}", [ArticleController::class, "show"]);
Route::get("/umkm", [UmkmController::class, "index"]);
Route::get("/umkm/{umkm}", [UmkmController::class, "show"]);
Route::get("/tour-packages", [TourPackageController::class, "index"]);
Route::get("/tour-packages/{tour_package}", [
    TourPackageController::class,
    "show",
]);

// Authenticated routes
Route::middleware("auth:sanctum")->group(function () {
    Route::post("/logout", [AuthController::class, "logout"]);
    Route::post("/change-password", [
        PasswordController::class,
        "changePassword",
    ]);

    // Category management (any authenticated admin)
    Route::apiResource(
        "/article-categories",
        ArticleCategoryController::class,
    )->only(["store", "update", "destroy"]);
    Route::apiResource("/umkm-categories", UmkmCategoryController::class)->only(
        ["store", "update", "destroy"],
    );
    Route::apiResource("/tour-categories", TourCategoryController::class)->only(
        ["store", "update", "destroy"],
    );

    // Content modules
    Route::apiResource("/track-records", TrackRecordController::class)->except([
        "index",
        "show",
    ]);
    Route::post("/track-records/{id}/publish", [
        TrackRecordController::class,
        "publish",
    ]);
    Route::post("/track-records/{id}/unpublish", [
        TrackRecordController::class,
        "unpublish",
    ]);

    Route::apiResource(
        "/whatsapp-numbers",
        WhatsappNumberController::class,
    )->except(["index", "show"]);
    Route::post("/whatsapp-numbers/{id}/publish", [
        WhatsappNumberController::class,
        "publish",
    ]);
    Route::post("/whatsapp-numbers/{id}/unpublish", [
        WhatsappNumberController::class,
        "unpublish",
    ]);

    Route::apiResource(
        "/organization-members",
        OrganizationMemberController::class,
    )->except(["index", "show"]);
    Route::post("/organization-members/{id}/publish", [
        OrganizationMemberController::class,
        "publish",
    ]);
    Route::post("/organization-members/{id}/unpublish", [
        OrganizationMemberController::class,
        "unpublish",
    ]);

    Route::apiResource("/partners", PartnerController::class)->except([
        "index",
        "show",
    ]);
    Route::post("/partners/{id}/publish", [
        PartnerController::class,
        "publish",
    ]);
    Route::post("/partners/{id}/unpublish", [
        PartnerController::class,
        "unpublish",
    ]);

    Route::apiResource(
        "/village-potentials",
        VillagePotentialController::class,
    )->except(["index", "show"]);
    Route::post("/village-potentials/{id}/publish", [
        VillagePotentialController::class,
        "publish",
    ]);
    Route::post("/village-potentials/{id}/unpublish", [
        VillagePotentialController::class,
        "unpublish",
    ]);

    Route::apiResource("/articles", ArticleController::class)->except([
        "index",
        "show",
    ]);
    Route::post("/articles/{id}/publish", [
        ArticleController::class,
        "publish",
    ]);
    Route::post("/articles/{id}/unpublish", [
        ArticleController::class,
        "unpublish",
    ]);

    Route::apiResource("/umkm", UmkmController::class)->except([
        "index",
        "show",
    ]);
    Route::post("/umkm/{id}/publish", [UmkmController::class, "publish"]);
    Route::post("/umkm/{id}/unpublish", [UmkmController::class, "unpublish"]);

    Route::apiResource("/tour-packages", TourPackageController::class)->except([
        "index",
        "show",
    ]);
    Route::post("/tour-packages/{id}/publish", [
        TourPackageController::class,
        "publish",
    ]);
    Route::post("/tour-packages/{id}/unpublish", [
        TourPackageController::class,
        "unpublish",
    ]);

    // Super Admin only
    Route::middleware("role:super_admin")->group(function () {
        Route::apiResource("/admins", AdminController::class)->except(["show"]);
    });
});
