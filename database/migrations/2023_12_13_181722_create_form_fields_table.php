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
        Schema::create('FormField', function (Blueprint $table) {
            $table->string('name', 50)->primary();
            $table->string('label', 50);
            $table->string('type', 30);
            $table->integer('order');
            $table->string('placeholder', 50)->default('');
            $table->boolean('isTextArea')->default(false);
            $table->boolean('isCustomField')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('FormField');
    }
};
