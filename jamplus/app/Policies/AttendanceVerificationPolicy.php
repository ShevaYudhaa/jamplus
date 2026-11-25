<?php
namespace App\Policies;
use App\Models\{AttendanceVerification,User};
use App\Policies\RegistrationPolicy;
class AttendanceVerificationPolicy {
 public function manage(User $user, AttendanceVerification $verification): bool { return (new RegistrationPolicy)->manage($user,$verification->registration); }
 public function viewEvidence(User $user, AttendanceVerification $verification): bool { return $verification->registration->user_id===$user->id || $this->manage($user,$verification); }
}
