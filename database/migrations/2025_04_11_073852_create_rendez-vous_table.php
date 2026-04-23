<?php

use App\Enums\Etat;
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
        Schema::create('rendez_vous', function (Blueprint $table) {
            $table->id();
            $table->dateTime('dateHeureDebut');
            $table->text('motif');
            $table->foreignId('user_id')->constrained('users');
            $table->string('etat')->default(Etat::CONFIRMER->value);
            $table->foreignId('veterinaire_id')->constrained('veterinaires')->cascadeOnDelete();
            $table->foreignId('animal_id')->constrained('animals')->cascadeOnDelete();
            $table->softDeletes();

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
