<?php

namespace App\Models;

use App\Models\User;
use App\Models\Lecturer;
use App\Models\Proposal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dosen_pa_id',
        'nim',
        'class',
    ];

    public function user(): BelongsTo
    { 
        return $this->belongsTo(User::class);
    }

    public function dosen_pa(): BelongsTo
    {
        return $this->belongsTo(Lecturer::class, 'foreign_key');
    }

    public function proposal(): HasOne
    {
        return $this->hasOne(Proposal::class);
    }
}
