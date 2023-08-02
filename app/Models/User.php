<?php

namespace App\Models;

use App\Models\Role;
use App\Models\Student;
use App\Models\Lecturer;
use Laravel\Scout\Searchable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// class User extends Authenticatable implements MustVerifyEmail
class User extends Authenticatable

{
    use HasRoles, HasApiTokens, HasFactory, Notifiable;
    use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'gender',
        'phone',
        'avatar',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // public function roles(): BelongsToMany
    // {
    //     return $this->belongsToMany(Role::class, 'role_user');
    // }
    
    public function lecturer(): HasOne
    {
        return $this->hasOne(Lecturer::class);
    }

    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    // public function hasRole($role)
    // {
    //     return $this->roles()->where('name', $role)->exists();
    // }

    // public function isCoordinator()
    // {
    //     return $this->role_user == 1;
    // }

    // public function isLecturer()
    // {
    //     return $this->role_user == 2;
    // }

    // public function isStudent()
    // {
    //     return $this->role_user == 3;
    // }

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
