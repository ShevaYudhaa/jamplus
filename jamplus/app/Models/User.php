<?php

namespace App\Models;

use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    // Skema SQL tidak memiliki remember_token.
    protected $rememberTokenName = '';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'study_program_id',
        'name',
        'email',
        'password',
        'student_number',
        'angkatan',
        'role',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'role' => UserRole::class,
            'is_active' => 'boolean',
            'angkatan' => 'integer',
        ];
    }

    public function studyProgram(): BelongsTo
    {
        return $this->belongsTo(StudyProgram::class);
    }

    public function creatorAccesses(): HasMany
    {
        return $this->hasMany(EventCreatorAccess::class);
    }

    public function grantedCreatorAccesses(): HasMany
    {
        return $this->hasMany(EventCreatorAccess::class, 'granted_by');
    }

    public function createdEvents(): HasMany
    {
        return $this->hasMany(Event::class, 'creator_id');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function approvedRegistrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class, 'approved_by');
    }

    public function verifiedAttendances(): HasMany
    {
        return $this->hasMany(AttendanceVerification::class, 'verified_by');
    }

    public function rewards(): HasManyThrough
    {
        return $this->hasManyThrough(StudentReward::class, EventRegistration::class, 'user_id', 'registration_id');
    }
}
