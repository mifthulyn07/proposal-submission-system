<?php

namespace App\Models;

use App\Models\User;
use App\Models\Lecturer;
use App\Models\Proposal;
use App\Models\ProposalProcess;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'user_id',
        'lecturer_id',
        'nim',
        'class',
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

    public function lecturer(): BelongsTo
    {
        return $this->belongsTo(Lecturer::class);
    }

    public function proposal(): HasOne
    {
        return $this->hasOne(Proposal::class);
    }

    public function proposal_process(): HasOne
    {
        return $this->hasOne(ProposalProcess::class);
    }
}
