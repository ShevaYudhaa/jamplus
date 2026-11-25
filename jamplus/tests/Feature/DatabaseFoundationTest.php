<?php

namespace Tests\Feature;

use App\Enums\AudienceScope;
use App\Enums\EventStatus;
use App\Enums\RegistrationStatus;
use App\Enums\RewardType;
use App\Enums\UserRole;
use App\Enums\VerificationStatus;
use App\Models\AttendanceVerification;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\EventCreatorAccess;
use App\Models\EventRegistration;
use App\Models\EventTargetProgram;
use App\Models\StudentReward;
use App\Models\StudyProgram;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DatabaseFoundationTest extends TestCase
{
    use RefreshDatabase;

    public function test_schema_has_only_domain_tables_and_migration_tracking(): void
    {
        $this->assertEqualsCanonicalizing([
            'study_programs', 'users', 'event_creator_access', 'event_categories',
            'events', 'event_target_programs', 'event_registrations',
            'attendance_verifications', 'student_rewards', 'migrations',
        ], Schema::getTableListing(schemaQualified: false));

        $this->assertFalse(Schema::hasColumn('users', 'remember_token'));
        $this->assertFalse(Schema::hasColumn('users', 'email_verified_at'));
        $this->assertFalse(Schema::hasColumn('event_target_programs', 'updated_at'));
    }

    public function test_seeder_is_idempotent_and_preserves_edited_accounts_and_programs(): void
    {
        $this->seed();

        $admin = User::where('email', 'sekprod.p01@kampus.test')->firstOrFail();
        $student = User::where('email', 'p01001@mahasiswa.test')->firstOrFail();
        $this->assertTrue(Hash::check('Jamplus123!', $admin->password));
        $this->assertTrue(Hash::check('P01001', $student->password));
        $this->assertTrue($admin->studyProgram->is($student->studyProgram));
        $this->assertNull($admin->student_number);
        $this->assertNull($admin->angkatan);

        $admin->update(['password' => 'KataSandiBaru!', 'is_active' => false]);
        $admin->studyProgram->update(['name' => 'Nama Prodi Asli']);
        $this->seed();

        $this->assertDatabaseCount('study_programs', 9);
        $this->assertDatabaseCount('users', 27);
        $this->assertDatabaseCount('event_categories', 6);
        $this->assertSame(9, User::where('role', UserRole::Admin)->count());
        $this->assertSame(18, User::where('role', UserRole::Mahasiswa)->count());
        $this->assertTrue(Hash::check('KataSandiBaru!', $admin->fresh()->password));
        $this->assertFalse($admin->fresh()->is_active);
        $this->assertSame('Nama Prodi Asli', $admin->fresh()->studyProgram->name);
    }

    public function test_relationships_casts_and_registration_cascades_follow_the_schema(): void
    {
        $admin = User::factory()->admin()->create();
        $program = $admin->studyProgram;
        $student = User::factory()->create(['study_program_id' => $program->id]);
        $access = EventCreatorAccess::create([
            'user_id' => $student->id, 'granted_by' => $admin->id,
            'study_program_id' => $program->id, 'is_active' => true,
            'granted_at' => now(),
        ]);
        $category = EventCategory::create(['name' => 'Seminar']);
        $event = Event::create([
            'creator_id' => $student->id, 'organizer_program_id' => $program->id,
            'category_id' => $category->id, 'title' => 'Seminar Pengujian',
            'start_at' => now()->subDays(2), 'end_at' => now()->subDay(),
            'reward_type' => RewardType::Both, 'jam_plus_offer' => '2.50',
            'soft_skill_points_offer' => '3.75', 'audience_scope' => AudienceScope::Selected,
            'status' => EventStatus::Completed,
        ]);
        $target = EventTargetProgram::create(['event_id' => $event->id, 'study_program_id' => $program->id]);
        $registration = EventRegistration::create([
            'event_id' => $event->id, 'user_id' => $student->id,
            'status' => RegistrationStatus::Approved, 'registered_at' => now()->subDays(3),
            'approved_by' => $admin->id, 'approved_at' => now()->subDays(3),
        ]);
        $attendance = AttendanceVerification::create([
            'registration_id' => $registration->id, 'evidence_file' => 'bukti/uji.pdf',
            'verification_status' => VerificationStatus::Approved,
            'verified_by' => $admin->id, 'verified_at' => now(),
        ]);
        // Fixture skema; alur pemberian reward oleh service dikerjakan pada tahap 6.
        $reward = StudentReward::create([
            'registration_id' => $registration->id, 'jam_plus' => '2.50', 'soft_skill_points' => '3.75',
        ]);

        $this->assertSame(UserRole::Mahasiswa, $student->role);
        $this->assertTrue($student->creatorAccesses->first()->is($access));
        $this->assertTrue($access->user->is($student));
        $this->assertTrue($access->grantedBy->is($admin));
        $this->assertTrue($access->studyProgram->is($program));
        $this->assertTrue($event->creator->is($student));
        $this->assertTrue($event->category->is($category));
        $this->assertTrue($event->organizerProgram->is($program));
        $this->assertTrue($event->targetPrograms->first()->is($program));
        $this->assertTrue($program->targetedEvents->first()->is($event));
        $this->assertTrue($target->event->is($event));
        $this->assertTrue($target->studyProgram->is($program));
        $target->touch(); // Tidak boleh mencoba menulis kolom updated_at.
        $this->assertSame(EventStatus::Completed, $event->fresh()->status);
        $this->assertSame(RewardType::Both, $event->fresh()->reward_type);
        $this->assertSame(AudienceScope::Selected, $event->fresh()->audience_scope);
        $this->assertTrue($event->fresh()->end_at->isPast());
        $this->assertSame(RegistrationStatus::Approved, $registration->fresh()->status);
        $this->assertTrue($registration->user->is($student));
        $this->assertTrue($registration->event->is($event));
        $this->assertTrue($registration->approvedBy->is($admin));
        $this->assertTrue($registration->attendanceVerification->is($attendance));
        $this->assertTrue($registration->reward->is($reward));
        $this->assertSame(VerificationStatus::Approved, $attendance->fresh()->verification_status);
        $this->assertTrue($attendance->registration->is($registration));
        $this->assertTrue($attendance->verifiedBy->is($admin));
        $this->assertTrue($reward->registration->is($registration));
        $this->assertSame('2.50', $reward->fresh()->jam_plus);
        $this->assertSame('3.75', $reward->fresh()->soft_skill_points);
        $this->assertTrue($student->rewards->first()->is($reward));
        $this->assertEquals(2.5, $student->rewards()->sum('jam_plus'));

        // Verifikator/pemberi approval nullable, peserta dan pembuat event tetap ada.
        $access->delete(); // Menghilangkan FK granted_by yang memang membatasi delete admin.
        $admin->delete();
        $this->assertNull($registration->fresh()->approved_by);
        $this->assertNull($attendance->fresh()->verified_by);

        $registration->delete();
        $this->assertModelMissing($attendance);
        $this->assertModelMissing($reward);
        $this->assertModelExists($event);
    }

    public function test_creator_access_cannot_be_duplicated_for_the_same_student_and_program(): void
    {
        $admin = User::factory()->admin()->create();
        $student = User::factory()->create(['study_program_id' => $admin->study_program_id]);
        $attributes = [
            'user_id' => $student->id, 'study_program_id' => $admin->study_program_id,
            'granted_by' => $admin->id,
        ];
        EventCreatorAccess::create($attributes);

        $this->expectException(QueryException::class);
        EventCreatorAccess::create($attributes);
    }
}
