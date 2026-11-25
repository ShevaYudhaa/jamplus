<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentReward extends Model
{
    protected $fillable = [
        'registration_id',
        'jam_plus',
        'soft_skill_points',
    ];

    protected function casts(): array
    {
        return [
            'jam_plus' => 'decimal:2',
            'soft_skill_points' => 'decimal:2',
        ];
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(EventRegistration::class, 'registration_id');
    }
}
