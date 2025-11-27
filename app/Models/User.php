<?php

namespace App\Models;
use App\Models\UserDogLike;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'bio',
        'location',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function likedDogs()
    {
        return $this->hasMany(UserDogLike::class);
    }

    public function hasLikedBreed($breedName)
    {
        return $this->likedDogs()->where('breed_name', $breedName)->exists();
    }

    public function getLikedBreedsCount()
    {
        return $this->likedDogs()->count();
    }
}