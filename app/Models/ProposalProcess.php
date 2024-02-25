<?php

namespace App\Models;

use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProposalProcess extends Model
{
    use HasFactory, Sluggable;
    
    protected $fillable = [
        'student_id',
        'type',
        'date',
        'requirements',
        'comment',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'customslug'
            ]
        ];
    }

    public function getCustomslugAttribute(): string
    {
        return Str::random(8);
    }

    public function student(): BelongsTo
    { 
        return $this->belongsTo(Student::class);
    }

    public function submit_proposals(): HasMany
    {
        return $this->hasMany(SubmitProposal::class);
    }
}
