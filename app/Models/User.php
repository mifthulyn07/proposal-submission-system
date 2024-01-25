<?php

namespace App\Models;

use App\Models\Student;
use App\Models\Lecturer;
use Laravel\Scout\Searchable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

// class User extends Authenticatable implements MustVerifyEmail
class User extends Authenticatable

{ 
    use HasRoles, HasApiTokens, HasFactory, Notifiable, Searchable, Sluggable;

    protected $fillable = [
        'name',
        'gender',
        'phone',
        'avatar',
        'email',
        'password',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    public function lecturer(): HasOne
    {
        return $this->hasOne(Lecturer::class);
    }

    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    public function toSearchableArray(): array
    {
        return [
            'name'          => $this->name,
            'gender'        => $this->gender,
            'phone'         => $this->phone,
            'email'         => $this->email,
        ];
    }
}
