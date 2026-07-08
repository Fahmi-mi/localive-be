<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create("partners", function (Blueprint $table) {
            $table->id();
            $table->string("logo")->nullable();
            $table->json("name");
            $table->json("description")->nullable();
            $table->enum("status", ["draft", "published"])->default("draft");
            $table->timestamp("published_at")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("partners");
    }
};
