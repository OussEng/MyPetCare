<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vaccination extends Model
{
    use HasFactory;

    protected $fillable = ['nom_vaccine', 'info'];




    public function animals(): BelongsToMany
    {
        return $this->belongsToMany(Animal::class);
    }

    public function espece() : BelongsTo
    {
        return $this->belongsTo(Espece::class);
    }

}
