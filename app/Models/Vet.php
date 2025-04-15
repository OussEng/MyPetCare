<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vet extends Model
{
    use HasFactory;

    protected $fillable = ['numeroLicence', 'nomClinique','NbAnsExperience','dateDeNaissance','certification','licenceExpiration','horaires', 'user_id'];



    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function langues(): belongsToMany
    {
        return $this->belongsToMany(Langues::class);
    }
}
