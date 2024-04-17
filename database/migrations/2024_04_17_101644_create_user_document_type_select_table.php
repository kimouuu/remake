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
        Schema::create('user_document_type_select', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_document_type_id')->constrained('user_document_types')->onDelete('cascade');
            $table->string('select_option', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_document_type_select');
    }
};
