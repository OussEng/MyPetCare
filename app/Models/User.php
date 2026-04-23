<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use SoftDeletes;



    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'prenom',
        'nom',
        'email',
        'password',
        'numero',
        'adresse',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function animals() : hasMany
    {
        return $this->hasMany(Animal::class);
    }

    public function rendezvous() : hasMany
    {
        return $this->hasMany(RendezVous::class);
    }

    public function vet()
    {
        return $this->hasOne(Vet::class);
    }

    public function isVet()
    {
        return $this->hasRole('veterinarian');
    }

    public function isPendingVet(){
        return $this->vet()->exists() && $this->hasRole("user");
    }

    public function isAdmin(){
        return $this->hasRole('admin');
    }


    public function roles() : BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($role)
    {
        return $this->roles()->where('role', $role)->exists();
    }

}
