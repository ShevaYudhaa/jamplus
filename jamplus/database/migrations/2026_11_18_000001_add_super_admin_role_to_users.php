<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('admin','mahasiswa','super_admin') NOT NULL");
    }
    public function down(): void {
        if (DB::table('users')->where('role', 'super_admin')->exists()) {
            throw new \RuntimeException('Tidak dapat rollback: masih ada akun super_admin.');
        }
        DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('admin','mahasiswa') NOT NULL");
    }
};
