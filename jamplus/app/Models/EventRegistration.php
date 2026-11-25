<?php

namespace App\Models;

use App\Enums\RegistrationStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EventRegistration extends Model
{
    protected $fillable = [
        'event_id',
        'user_id',
        'status',
        'registered_at',
        'approved_by',
        'approved_at',
        'rejection_notes',
    ];

    protected function casts(): array
    {
        return [
            'status' => RegistrationStatus::class,
            'registered_at' => 'datetime',
            'approved_at' => 'datetime',
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function attendanceVerification(): HasOne
    {
        return $this->hasOne(AttendanceVerification::class, 'registration_id');
    }

    public function reward(): HasOne
    {
        return $this->hasOne(StudentReward::class, 'registration_id');
    }
}
