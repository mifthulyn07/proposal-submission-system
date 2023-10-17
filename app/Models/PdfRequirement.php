<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PdfRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'proposal_process_id',
        'pdf_name',
    ];

    public function proposal_process(): BelongsTo
    { 
        return $this->belongsTo(ProposalProcess::class);
    }
}
