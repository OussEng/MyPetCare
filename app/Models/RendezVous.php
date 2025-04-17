<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RendezVous extends Model
{
    use HasFactory;

    protected $fillable = ['dateHeuredebut', 'motif'];



    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function etat() : BelongsTo
    {
        return $this->belongsTo(Etat::class);
    }

    public function animal() :  BelongsTo
    {
        return $this->belongsTo(Animal::class);
    }

    public function veterinaire() :   BelongsTo
    {
        return $this->belongsTo(Vet::class);
    }
}
