<?php

namespace App\Models;

use App\Models\TimeEntry;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'client',
        'is_tracked',
        'progress',
        'access',
    ];
    public function timeEntries(): HasMany
    {
        return $this->hasMany(TimeEntry::class);
    }
}
