<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_number',
        'name',
        'position',
        'visi',
        'misi',
        'photo_path',
    ];

    /**
     * Dapatkan semua votes untuk kandidat ini.
     */
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }
}
