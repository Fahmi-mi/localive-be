<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create("articles", function (Blueprint $table) {
            $table->id();
            $table->string("slug")->unique();
            $table->foreignId("category_id")->constrained("article_categories")->cascadeOnDelete();
            $table->foreignId("user_id")->constrained("users")->cascadeOnDelete();
            $table->json("title");
            $table->json("content");
            $table->date("date");
            $table->string("image")->nullable();
            $table->enum("status", ["draft", "published"])->default("draft");
            $table->timestamp("published_at")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("articles");
    }
};
