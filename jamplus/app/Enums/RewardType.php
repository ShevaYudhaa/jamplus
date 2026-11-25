<?php

namespace App\Enums;

enum RewardType: string
{
    case JamPlus = 'jam_plus';
    case SoftSkill = 'soft_skill';
    case Both = 'both';
}
