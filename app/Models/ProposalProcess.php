<?php

namespace App\Models;

use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProposalProcess extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'student_id',
        'type',
        'date',
        'comment',
    ];

    public function student(): BelongsTo
    { 
        return $this->belongsTo(Student::class);
    }

    public function submit_proposals(): HasMany
    {
        return $this->hasMany(SubmitProposal::class);
    }

    public function pdf_requirements(): HasMany
    {
        return $this->hasMany(PdfRequirement::class);
    }
}
