<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Topic extends Model
{
    use HasFactory, Searchable, Sluggable;

    protected $fillable = [
        'name',
        'date',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function proposal(): HasMany
    {
        return $this->hasMany(Proposal::class);
    }

    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'date' => $this->date,
        ];
    }
}
