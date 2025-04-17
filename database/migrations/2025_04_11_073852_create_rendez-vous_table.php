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
        Schema::create('rendez_vouses', function (Blueprint $table) {
            $table->id();
            $table->dateTime('dateHeuredebut');
            $table->dateTime('dateFin');
            $table->text('motif');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('animal_id')->constrained();

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
