<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'nim',
        'title',
        'year',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
