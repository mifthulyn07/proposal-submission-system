<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Topic extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'name',
        'date',
    ];

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
