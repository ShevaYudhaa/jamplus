<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Nama, tipe, indeks, dan aksi FK mengikuti jamplus.sql.
        Schema::create('study_programs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            $table->string('code', 20);
            $table->string('name', 100);
            $table->timestamps();
            $table->unique('code', 'uq_study_programs_code');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            $table->unsignedBigInteger('study_program_id');
            $table->string('name', 100);
            $table->string('email', 150);
            $table->string('password', 255);
            $table->string('student_number', 30)->nullable();
            $table->unsignedSmallInteger('angkatan')->nullable()->comment('Tahun angkatan, NULL untuk admin');
            $table->enum('role', ['admin', 'mahasiswa']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unique('email', 'uq_users_email');
            $table->unique('student_number', 'uq_users_student_number');
            $table->index('study_program_id', 'idx_users_study_program');
            $table->foreign('study_program_id', 'fk_users_study_program')
                ->references('id')->on('study_programs')->cascadeOnUpdate();
        });

        Schema::create('event_creator_access', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('granted_by');
            $table->unsignedBigInteger('study_program_id');
            $table->boolean('is_active')->default(true);
            $table->dateTime('granted_at')->nullable();
            $table->dateTime('revoked_at')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'study_program_id'], 'uq_creator_access_user_program');
            $table->index('granted_by', 'idx_creator_access_granted_by');
            $table->index('study_program_id', 'idx_creator_access_program');
            $table->foreign('user_id', 'fk_creator_access_user')
                ->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('granted_by', 'fk_creator_access_granted_by')
                ->references('id')->on('users')->cascadeOnUpdate();
            $table->foreign('study_program_id', 'fk_creator_access_program')
                ->references('id')->on('study_programs')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('event_categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('events', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            $table->unsignedBigInteger('creator_id');
            $table->unsignedBigInteger('organizer_program_id')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->string('title', 200);
            $table->text('description')->nullable();
            $table->string('location', 200)->nullable();
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->dateTime('registration_deadline')->nullable();
            $table->integer('quota')->nullable();
            $table->enum('reward_type', ['jam_plus', 'soft_skill', 'both']);
            $table->decimal('jam_plus_offer', 6, 2)->nullable();
            $table->decimal('soft_skill_points_offer', 6, 2)->nullable();
            $table->enum('audience_scope', ['all', 'selected']);
            $table->string('poster', 255)->nullable();
            $table->enum('status', ['draft', 'published', 'closed', 'completed', 'cancelled'])->default('draft');
            $table->timestamps();
            $table->index('creator_id', 'idx_events_creator');
            $table->index('organizer_program_id', 'idx_events_organizer');
            $table->index('category_id', 'idx_events_category');
            $table->foreign('creator_id', 'fk_events_creator')
                ->references('id')->on('users')->cascadeOnUpdate();
            $table->foreign('organizer_program_id', 'fk_events_organizer_program')
                ->references('id')->on('study_programs')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('category_id', 'fk_events_category')
                ->references('id')->on('event_categories')->cascadeOnUpdate();
        });

        Schema::create('event_target_programs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('study_program_id');
            $table->timestamp('created_at')->nullable();
            $table->unique(['event_id', 'study_program_id'], 'uq_event_target');
            $table->index('study_program_id', 'idx_event_target_program');
            $table->foreign('event_id', 'fk_event_target_event')
                ->references('id')->on('events')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('study_program_id', 'fk_event_target_program')
                ->references('id')->on('study_programs')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('event_registrations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('user_id');
            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled'])->default('pending');
            $table->dateTime('registered_at')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->text('rejection_notes')->nullable()->comment('Alasan jika ditolak');
            $table->timestamps();
            $table->unique(['event_id', 'user_id'], 'uq_registration_event_user');
            $table->index('user_id', 'idx_registration_user');
            $table->index('approved_by', 'idx_registration_approved_by');
            $table->foreign('event_id', 'fk_registration_event')
                ->references('id')->on('events')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('user_id', 'fk_registration_user')
                ->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('approved_by', 'fk_registration_approved_by')
                ->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();
        });

        Schema::create('attendance_verifications', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            $table->unsignedBigInteger('registration_id');
            $table->string('evidence_file', 255);
            $table->text('evidence_description')->nullable();
            $table->enum('verification_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->dateTime('verified_at')->nullable();
            $table->text('verification_notes')->nullable();
            $table->timestamps();
            $table->unique('registration_id', 'uq_attendance_registration');
            $table->index('verified_by', 'idx_attendance_verified_by');
            $table->foreign('registration_id', 'fk_attendance_registration')
                ->references('id')->on('event_registrations')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('verified_by', 'fk_attendance_verified_by')
                ->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();
        });

        Schema::create('student_rewards', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            $table->unsignedBigInteger('registration_id');
            $table->decimal('jam_plus', 6, 2)->nullable();
            $table->decimal('soft_skill_points', 6, 2)->nullable();
            $table->timestamps();
            $table->unique('registration_id', 'uq_rewards_registration');
            $table->foreign('registration_id', 'fk_rewards_registration')
                ->references('id')->on('event_registrations')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        foreach ([
            'student_rewards', 'attendance_verifications', 'event_registrations',
            'event_target_programs', 'events', 'event_categories',
            'event_creator_access', 'users', 'study_programs',
        ] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
