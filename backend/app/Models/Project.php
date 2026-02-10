<?php

namespace App\Models;

use App\Models\TimeEntry;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    public function timeEntries()
    {
        return $this->hasMany(TimeEntry::class);
    }
}
