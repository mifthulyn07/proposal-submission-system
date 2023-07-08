<?php

namespace App\Models;

use App\Models\User;
use App\Models\Student;
use App\Models\Proposal;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lecturer extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'user_id',
        'nip',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
