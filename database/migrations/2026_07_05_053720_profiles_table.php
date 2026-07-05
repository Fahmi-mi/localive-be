<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create("profiles", function (Blueprint $table) {
            $table->id();
            $table->json("business_name");
            $table->json("owner");
            $table->date("founded_date")->nullable();
            $table->json("location")->nullable();
            $table->string("phone")->nullable();
            $table->string("email")->nullable();
            $table->string("ig_url")->nullable();
            $table->string("yt_url")->nullable();
            $table->enum("status", ["draft", "published"])->default("draft");
            $table->timestamp("published_at")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("profiles");
    }
};
