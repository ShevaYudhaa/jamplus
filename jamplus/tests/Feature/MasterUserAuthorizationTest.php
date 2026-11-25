<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\{StudyProgram,User};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasterUserAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_super_admin_can_open_master_users(): void
    {
        $program = StudyProgram::create(['code' => 'TST', 'name' => 'Test Prodi']);
        $super = User::factory()->create(['study_program_id' => $program->id, 'role' => UserRole::SuperAdmin]);
        $admin = User::factory()->create(['study_program_id' => $program->id, 'role' => UserRole::Admin]);
        $student = User::factory()->create(['study_program_id' => $program->id, 'role' => UserRole::Mahasiswa]);
        $this->actingAs($super)->get(route('master.users.index'))->assertOk();
        $this->actingAs($admin)->get(route('master.users.index'))->assertForbidden();
        $this->actingAs($student)->get(route('master.users.index'))->assertForbidden();
    }

    public function test_super_admin_cannot_disable_own_account(): void
    {
        $program = StudyProgram::create(['code' => 'TST', 'name' => 'Test Prodi']);
        $super = User::factory()->create(['study_program_id' => $program->id, 'role' => UserRole::SuperAdmin]);
        $this->actingAs($super)->patch(route('master.users.status', $super))->assertStatus(422);
        $this->assertTrue($super->fresh()->is_active);
    }
}
