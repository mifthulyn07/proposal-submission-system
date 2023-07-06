<?php

namespace App\Models;

use App\Models\User;
use App\Models\Student;
use App\Models\Proposal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lecturer extends Model
{
    use HasFactory;

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

    public function student(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}
