<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\StudyProgram;
use App\Models\EventCategory;
use App\Enums\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::transaction(function () {
            for ($number = 1; $number <= 9; $number++) {
                $code = sprintf('P%02d', $number);
                // firstOrCreate menjaga nama prodi asli dan akun yang sudah disunting.
                $program = StudyProgram::firstOrCreate(['code' => $code], [
                    'name' => 'Program Studi '.$code,
                ]);

                User::firstOrCreate(['email' => 'sekprod.'.strtolower($code).'@kampus.test'], [
                    'study_program_id' => $program->id,
                    'name' => 'Sekretaris Prodi '.$code,
                    'password' => 'Jamplus123!',
                    'student_number' => null,
                    'angkatan' => null,
                    'role' => UserRole::Admin,
                    'is_active' => true,
                ]);

                for ($student = 1; $student <= 2; $student++) {
                    $nim = sprintf('%s%03d', $code, $student);
                    User::firstOrCreate(['email' => strtolower($nim).'@mahasiswa.test'], [
                        'study_program_id' => $program->id,
                        'name' => 'Mahasiswa '.$nim,
                        'password' => $nim,
                        'student_number' => $nim,
                        'angkatan' => 2026,
                        'role' => UserRole::Mahasiswa,
                        'is_active' => true,
                    ]);
                }
            }

            $firstProgram = StudyProgram::where('code', 'P01')->firstOrFail();
            User::firstOrCreate(['email' => 'superadmin@kampus.test'], [
                'study_program_id' => $firstProgram->id, // FK wajib; super_admin tetap memiliki akses global.
                'name' => 'Super Administrator',
                'password' => 'Jamplus123!',
                'student_number' => null,
                'angkatan' => null,
                'role' => UserRole::SuperAdmin,
                'is_active' => true,
            ]);

            foreach (['Seminar', 'Workshop', 'Lomba', 'Kepanitiaan', 'Pengabdian Masyarakat', 'Organisasi'] as $name) {
                EventCategory::firstOrCreate(['name' => $name]);
            }
        });
    }
}
