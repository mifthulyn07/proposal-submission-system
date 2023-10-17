<?php

namespace App\Models;

use App\Models\Topic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubmitProposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'proposal_process_id',
        'topic_id',
        'title',
        'similarity',
        'proposal',
        'adding_topic',
        'accord',
    ];

    public function proposal_process(): BelongsTo
    { 
        return $this->belongsTo(ProposalProcess::class);
    }

    public function topic(): BelongsTo
    { 
        return $this->belongsTo(Topic::class);
    }
}
