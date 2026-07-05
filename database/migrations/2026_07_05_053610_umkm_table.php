<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create("umkm", function (Blueprint $table) {
            $table->id();
            $table->string("slug")->unique();
            $table->json("title");
            $table->json("description")->nullable();
            $table->foreignId("category_id")->constrained("umkm_categories")->cascadeOnDelete();
            $table->string("maps_link")->nullable();
            $table->string("image")->nullable();
            $table->enum("status", ["draft", "published"])->default("draft");
            $table->timestamp("published_at")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("umkm");
    }
};
