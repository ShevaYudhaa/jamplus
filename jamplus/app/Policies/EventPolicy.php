<?php
namespace App\Policies;
use App\Models\{Event,User};
use App\Enums\UserRole;
class EventPolicy {
 public function create(User $user): bool { return $user->is_active && ($user->role===UserRole::Admin || $user->creatorAccesses()->where('is_active',true)->where('study_program_id',$user->study_program_id)->exists()); }
 public function update(User $user,Event $event): bool { return $user->is_active && ($event->creator_id===$user->id || ($user->role===UserRole::Admin && $event->organizer_program_id===$user->study_program_id)); }
 public function manage(User $user,Event $event): bool { return $this->update($user,$event); }
}
