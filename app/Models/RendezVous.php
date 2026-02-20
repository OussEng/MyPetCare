<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Enums\Etat;

class RendezVous extends Model
{
    use HasFactory;

    protected $fillable = ['dateHeureDebut', 'motif','user_id','animal_id','veterinaire_id','etat'];

    protected $casts = [
        'etat' => Etat::class,
    ];



    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
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
