<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmitProposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'proposal_process_id',
        'topic_id',
        'title',
        'prop_pdf',
        'acc_advisor',
        'desc_advisor',
        'acc_coordinator',
        'desc_coordinator',
    ];
}
