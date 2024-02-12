<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->text('history')->nullable();
            $table->text('community_bio')->nullable();
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->string('video1')->nullable();
            $table->string('video2')->nullable();
            $table->text('community_structure')->nullable();
            $table->string('slogan', 100)->nullable();
            $table->string('community_name', 100)->nullable();
            $table->string('endpoint')->nullable();
            $table->string('sender')->nullable();
            $table->string('api_key')->nullable();
            $table->string('api_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
