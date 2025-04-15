<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Espece extends Model
{
    use HasFactory;

    protected $fillable = ['libelle'];


    public function animals(): HasMany
    {
        return $this->hasMany(Animal::class);

    }

}
