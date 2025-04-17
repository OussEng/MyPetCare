<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Animal extends Model
{
    use HasFactory;

    protected $table = 'animals';
    protected $fillable = [
        'nom','espece','sexe','race','dateNaissance','poids','vaccination','user_id'
    ];



    public function sexe(): BelongsTo
    {
        return $this->belongsTo(Sexe::class);
    }

    public function espece(): BelongsTo
    {
        return $this->belongsTo(Espece::class);
    }

    public function vaccinations(): BelongsToMany
    {
        return $this->belongsToMany(Vaccination::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function rendezvous(): HasMany
    {
        return $this->hasMany(RendezVous::class);
    }


}



