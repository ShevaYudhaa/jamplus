<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\{Event,EventRegistration,AttendanceVerification};
use App\Policies\{EventPolicy,RegistrationPolicy,AttendanceVerificationPolicy};
class AppServiceProvider extends ServiceProvider {
 public function register(): void {}
 public function boot(): void {
  Gate::policy(Event::class,EventPolicy::class);
  Gate::policy(EventRegistration::class,RegistrationPolicy::class);
  Gate::policy(AttendanceVerification::class,AttendanceVerificationPolicy::class);
 }
}
