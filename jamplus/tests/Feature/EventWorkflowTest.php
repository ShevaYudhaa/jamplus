<?php
namespace Tests\Feature;
use App\Enums\{EventStatus,RewardType,AudienceScope,RegistrationStatus,VerificationStatus};
use App\Models\{Event,EventCategory,EventRegistration,AttendanceVerification,User};
use App\Services\EventWorkflowService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;
class EventWorkflowTest extends TestCase {
 use RefreshDatabase;
 private function fixture(): array {
  $admin=User::factory()->admin()->create();
  $student=User::factory()->create(['study_program_id'=>$admin->study_program_id]);
  $category=EventCategory::create(['name'=>'Workshop']);
  $event=Event::create(['creator_id'=>$admin->id,'organizer_program_id'=>$admin->study_program_id,'category_id'=>$category->id,'title'=>'Workshop Pengujian','start_at'=>now()->addDays(2),'end_at'=>now()->addDays(3),'reward_type'=>RewardType::Both,'jam_plus_offer'=>2.5,'soft_skill_points_offer'=>3,'audience_scope'=>AudienceScope::All,'status'=>EventStatus::Published,'quota'=>1]);
  return compact('admin','student','event');
 }
 public function test_registration_and_approval_cannot_exceed_quota(): void {
  extract($this->fixture()); $service=app(EventWorkflowService::class);
  $service->register($event,$student);
  $registration=$event->registrations()->firstOrFail();
  $this->assertSame(RegistrationStatus::Pending,$registration->status);
  $service->decideRegistration($registration,$admin,true,null);
  $this->assertSame(RegistrationStatus::Approved,$registration->fresh()->status);
  $other=User::factory()->create(['study_program_id'=>$admin->study_program_id]);
  $service->register($event,$other);
  $this->expectException(ValidationException::class);
  $service->decideRegistration($event->registrations()->where('user_id',$other->id)->firstOrFail(),$admin,true,null);
 }
 public function test_verification_reward_is_idempotent_and_reversal_removes_reward(): void {
  extract($this->fixture());$service=app(EventWorkflowService::class);
  $registration=EventRegistration::create(['event_id'=>$event->id,'user_id'=>$student->id,'status'=>RegistrationStatus::Approved]);
  $verification=AttendanceVerification::create(['registration_id'=>$registration->id,'evidence_file'=>'evidence/test.pdf','verification_status'=>VerificationStatus::Pending]);
  $service->verify($verification,$admin,true,null);$service->verify($verification,$admin,true,null);
  $this->assertDatabaseCount('student_rewards',1);
  $this->assertDatabaseHas('student_rewards',['registration_id'=>$registration->id,'jam_plus'=>2.5,'soft_skill_points'=>3]);
  $service->verify($verification,$admin,false,'Bukti tidak valid');
  $this->assertDatabaseCount('student_rewards',0);
 }
 public function test_other_program_admin_cannot_manage_event(): void {
  extract($this->fixture());$otherAdmin=User::factory()->admin()->create();
  $this->assertFalse($otherAdmin->can('manage',$event));
  $this->assertTrue($admin->can('manage',$event));
  $this->assertFalse($student->can('create',Event::class));
 }
}
