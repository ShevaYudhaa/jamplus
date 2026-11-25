<?php

namespace App\Models;

use App\Enums\AudienceScope;
use App\Enums\EventStatus;
use App\Enums\RewardType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'creator_id',
        'organizer_program_id',
        'category_id',
        'title',
        'description',
        'location',
        'start_at',
        'end_at',
        'registration_deadline',
        'quota',
        'reward_type',
        'jam_plus_offer',
        'soft_skill_points_offer',
        'audience_scope',
        'poster',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_at' => 'datetime',
            'end_at' => 'datetime',
            'registration_deadline' => 'datetime',
            'quota' => 'integer',
            'reward_type' => RewardType::class,
            'jam_plus_offer' => 'decimal:2',
            'soft_skill_points_offer' => 'decimal:2',
            'audience_scope' => AudienceScope::class,
            'status' => EventStatus::class,
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function organizerProgram(): BelongsTo
    {
        return $this->belongsTo(StudyProgram::class, 'organizer_program_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(EventCategory::class, 'category_id');
    }

    public function targets(): HasMany
    {
        return $this->hasMany(EventTargetProgram::class);
    }

    public function targetPrograms(): BelongsToMany
    {
        return $this->belongsToMany(StudyProgram::class, 'event_target_programs', 'event_id', 'study_program_id')->withPivot(['id', 'created_at']);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }
}
