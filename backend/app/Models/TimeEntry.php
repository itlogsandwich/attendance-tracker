<?php

namespace App\Models;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeEntry extends Model
{
    /** @use HasFactory<\Database\Factories\TimeEntryFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'project_id',
        'start_time',
        'end_time',
        'total_seconds'
    ];

    function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
