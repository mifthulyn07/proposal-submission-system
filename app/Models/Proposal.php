<?php

namespace App\Models;

use App\Models\Topic;
use App\Models\Student;
use App\Models\Lecturer;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Proposal extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'topic_id',
        'student_id',
        'name',
        'nim',
        'type',
        'title',
        'year',
        'status',
        'adding_topic',
    ];

    public function lecturers(): BelongsToMany
    {
        return $this->belongsToMany(Lecturer::class, 'lecturer_proposal');
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
        ];
    }
}
