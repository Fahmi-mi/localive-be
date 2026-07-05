<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create("whatsapp_numbers", function (Blueprint $table) {
            $table->id();
            $table->string("number");
            $table->json("label");
            $table->enum("status", ["draft", "published"])->default("draft");
            $table->timestamp("published_at")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("whatsapp_numbers");
    }
};
