<?php

namespace App\Models;

use App\Models\User;
use App\Models\Student;
use App\Models\Proposal;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lecturer extends Model
{
    use HasFactory, Searchable, Sluggable;

    protected $fillable = [
        'user_id',
        'nip',
        'expertise',
        'barcode',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'user.name'
            ]
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function proposals(): BelongsToMany
    {
        return $this->belongsToMany(Proposal::class, 'lecturer_proposal');
    }

    public function proposal(): HasOne
    {
        return $this->hasOne(Proposal::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function toSearchableArray(): array
    {
        return [
            'user_id' => $this->user_id,
            'nip' => $this->nip,
        ];
    }

    public function makeSearchableUsing(Collection $models): Collection
    {
        return $models->load('user');
    }
}
