<?php

namespace App\Models;

use App\Models\Topic;
use App\Models\Student;
use App\Models\Lecturer;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proposal extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'topic_id',
        'student_id',
        'lecturer1_id',
        'lecturer2_id',
        'name',
        'nim',
        'type',
        'title',
        'year',
        'status_proposal',
    ];

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function lecturer() : BelongsTo
    {
        return $this->belongsTo(Lecturer::class);
    }

    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
        ];
    }
}
