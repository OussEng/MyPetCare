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
        Schema::create('language_vet', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vet_id')->constrained()->onDelete('cascade'); // Foreign key to the vets table
            $table->foreignId('language_id')->constrained()->onDelete('cascade'); // Foreign key to the languages table
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
