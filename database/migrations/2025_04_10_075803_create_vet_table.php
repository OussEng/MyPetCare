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
        Schema::create('veterinaires', function (Blueprint $table) {
            $table->id();
            $table->string('numeroLicence');
            $table->string('nomClinique');
            $table->integer('NbAnsExperience');
            $table->string('certification');
            $table->date('dateDeNaissance');
            $table->date('licenceExpiration');
            $table->string('adresseClinique');
            $table->boolean('isReviewed')->default(false);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vet');
    }
};
