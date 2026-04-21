<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Langue extends Model
{
    use HasFactory;
    protected $table = 'langues';
    protected $fillable = ['libelle'];



    public function vets(): belongsToMany
    {
        return $this->belongsToMany(Vet::class);
    }
}
