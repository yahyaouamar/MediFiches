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
        Schema::table('medical_card', function (Blueprint $table) {
            $table->date('tetanos_update')->nullable();
            $table->string('phone_number_doctor', 13)->nullable();
            $table->string('emergency_contact_parent', 13)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_card', function (Blueprint $table) {
            $table->dropColumn('tetanos_update');
            $table->dropColumn('phone_number_doctor');
            $table->dropColumn('emergency_contact_parent');
        });
    }
};