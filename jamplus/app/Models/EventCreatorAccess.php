<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventCreatorAccess extends Model
{
    protected $table = 'event_creator_access';

    protected $fillable = [
        'user_id',
        'granted_by',
        'study_program_id',
        'is_active',
        'granted_at',
        'revoked_at',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'granted_at' => 'datetime',
            'revoked_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function grantedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'granted_by');
    }

    public function studyProgram(): BelongsTo
    {
        return $this->belongsTo(StudyProgram::class);
    }
}
