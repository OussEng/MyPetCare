<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Espece extends Model
{
    use HasFactory;

    protected $table = 'especes';

    protected $fillable = ['libelle'];


    public function animals(): HasMany
    {
        return $this->hasMany(Animal::class);

    }

    public function vaccinations(): HasMany
    {
        return $this->hasMany(
            Vaccination::class,
            'espece_id',
            'id'
        );
    }

}
