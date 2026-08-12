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
        Schema::table('additional_field', function (Blueprint $table) {
            $table->timestamps();
            $table->foreign('field_name')->references('name')->on('FormField')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('additional_field', function (Blueprint $table) {
            $table->dropTimestamps();
            $table->dropForeign("field_name");
        });
    }
};
