<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudyProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function creatorAccesses(): HasMany
    {
        return $this->hasMany(EventCreatorAccess::class);
    }

    public function organizedEvents(): HasMany
    {
        return $this->hasMany(Event::class, 'organizer_program_id');
    }

    public function eventTargets(): HasMany
    {
        return $this->hasMany(EventTargetProgram::class);
    }

    public function targetedEvents(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_target_programs', 'study_program_id', 'event_id')->withPivot(['id', 'created_at']);
    }
}
