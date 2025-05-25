<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rate_result_tag', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rate_result_id');
            $table->unsignedBigInteger('tag_id');
            $table->timestamps();

            $table->foreign('rate_result_id')->references('id')->on('rate_results')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rate_result_tag');
    }
};
