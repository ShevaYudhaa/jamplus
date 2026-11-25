<?php
namespace App\Services;
use App\Models\{Event,EventRegistration,AttendanceVerification,StudentReward,User};
use App\Enums\{RegistrationStatus,VerificationStatus,EventStatus,AudienceScope,RewardType};
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
class EventWorkflowService {
 public function register(Event $event,User $user): void {
  DB::transaction(function()use($event,$user){
   $event=Event::whereKey($event->id)->lockForUpdate()->firstOrFail();
   if($user->role->value!=='mahasiswa' || !$user->is_active)abort(403);
   if($event->status!==EventStatus::Published || now()->gte($event->registration_deadline ?? $event->start_at))throw ValidationException::withMessages(['event'=>'Pendaftaran event ini sudah ditutup.']);
   if($event->audience_scope===AudienceScope::Selected && !$event->targets()->where('study_program_id',$user->study_program_id)->exists())throw ValidationException::withMessages(['event'=>'Event ini tidak tersedia untuk program studi Anda.']);
   if($event->registrations()->where('user_id',$user->id)->exists())throw ValidationException::withMessages(['event'=>'Anda sudah pernah mendaftar event ini.']);
   $event->registrations()->create(['user_id'=>$user->id,'status'=>RegistrationStatus::Pending,'registered_at'=>now()]);
  });
 }
 public function decideRegistration(EventRegistration $registration,User $actor,bool $approve,?string $notes): void {
  DB::transaction(function()use($registration,$actor,$approve,$notes){
   $reg=EventRegistration::whereKey($registration->id)->lockForUpdate()->firstOrFail();
   $event=Event::whereKey($reg->event_id)->lockForUpdate()->firstOrFail();
   if($reg->status!==RegistrationStatus::Pending)throw ValidationException::withMessages(['status'=>'Hanya pendaftaran pending yang bisa diproses.']);
   if($approve && $event->quota!==null && $event->registrations()->where('status','approved')->count()>=$event->quota)throw ValidationException::withMessages(['status'=>'Kuota sudah penuh.']);
   $reg->update(['status'=>$approve?RegistrationStatus::Approved:RegistrationStatus::Rejected,'approved_by'=>$approve?$actor->id:null,'approved_at'=>$approve?now():null,'rejection_notes'=>$approve?null:$notes]);
  });
 }
 public function verify(AttendanceVerification $verification,User $actor,bool $approve,?string $notes): void {
  DB::transaction(function()use($verification,$actor,$approve,$notes){
   $v=AttendanceVerification::whereKey($verification->id)->lockForUpdate()->firstOrFail();
   $reg=EventRegistration::with('event')->whereKey($v->registration_id)->lockForUpdate()->firstOrFail();
   if($reg->status!==RegistrationStatus::Approved)throw ValidationException::withMessages(['status'=>'Pendaftaran belum disetujui.']);
   $v->update(['verification_status'=>$approve?VerificationStatus::Approved:VerificationStatus::Rejected,'verified_by'=>$actor->id,'verified_at'=>now(),'verification_notes'=>$notes]);
   if(!$approve){StudentReward::where('registration_id',$reg->id)->delete();return;}
   $event=$reg->event;
   StudentReward::updateOrCreate(['registration_id'=>$reg->id],[
    'jam_plus'=>in_array($event->reward_type,[RewardType::JamPlus,RewardType::Both])?$event->jam_plus_offer:null,
    'soft_skill_points'=>in_array($event->reward_type,[RewardType::SoftSkill,RewardType::Both])?$event->soft_skill_points_offer:null,
   ]);
  });
 }
}
