<?php
namespace App\Policies;
use App\Models\{EventRegistration,User};
use App\Policies\EventPolicy;
class RegistrationPolicy {
 public function manage(User $user, EventRegistration $registration): bool {return (new EventPolicy)->manage($user,$registration->event);}
 public function cancel(User $user, EventRegistration $registration): bool {return $user->id===$registration->user_id && now()->lt($registration->event->start_at) && $registration->status->value!=='cancelled';}
}
