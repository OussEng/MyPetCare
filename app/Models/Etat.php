<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Etat extends Model
{
    use HasFactory;
    protected $table = 'etat';



    public function rendezvous() : HasMany
    {
        return $this->hasMany(Rendezvous::class);
    }
}
