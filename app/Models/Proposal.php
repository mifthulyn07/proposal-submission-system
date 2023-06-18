<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Laravel\Scout\Attributes\SearchUsingFullText;

class Proposal extends Model
{
    use HasFactory, Searchable;

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

    // public function toSearchableArray(): array
    // {
    //     return [
    //         'title' => $this->title,
    //     ];
    // }
    
    // #[SearchUsingFullText(['title'])]
    public function toSearchableArray(): array
    {
        // $array = $this->toArray();
 
        // Customize the data array...
 
        return [
            'title' => $this->title,
        ];
    }
}
