<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalProcess extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'student_id',
        'type',
        'requirements_pdf',
        'date',
    ];
}
