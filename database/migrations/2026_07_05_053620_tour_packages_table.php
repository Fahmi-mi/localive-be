<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create("tour_packages", function (Blueprint $table) {
            $table->id();
            $table->string("slug")->unique();
            $table->json("title");
            $table->json("description")->nullable();
            $table->foreignId("category_id")->constrained("tour_categories")->cascadeOnDelete();
            $table->string("image")->nullable();
            $table->enum("status", ["draft", "published"])->default("draft");
            $table->timestamp("published_at")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("tour_packages");
    }
};
