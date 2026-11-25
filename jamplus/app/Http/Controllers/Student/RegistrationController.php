<?php
namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;
use App\Enums\{RegistrationStatus,VerificationStatus,EventStatus};
use App\Models\{Event,EventRegistration,AttendanceVerification};
use App\Services\EventWorkflowService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
class RegistrationController extends Controller {
 public function store(Event $event,EventWorkflowService $service){$service->register($event,request()->user());return back()->with('success','Pendaftaran dikirim, menunggu persetujuan.');}
 public function cancel(EventRegistration $registration){abort_unless(request()->user()->can('cancel',$registration),403);$registration->update(['status'=>RegistrationStatus::Cancelled]);return back()->with('success','Pendaftaran dibatalkan.');}
 public function index(){abort_unless(request()->user()->role->value==='mahasiswa',403);return view('student.history',['registrations'=>request()->user()->registrations()->with(['event','attendanceVerification'])->latest()->paginate(12)]);}
 public function progress(){ $user=request()->user();abort_unless($user->role->value==='mahasiswa',403);$rewards=$user->rewards()->with('registration.event')->latest()->paginate(12);$totals=DB::table('student_rewards')->join('event_registrations', 'event_registrations.id', '=', 'student_rewards.registration_id')->where('event_registrations.user_id', $user->id)->selectRaw('COALESCE(SUM(student_rewards.jam_plus),0) as jam, COALESCE(SUM(student_rewards.soft_skill_points),0) as soft')->first();return view('student.progress',compact('rewards','totals'));}
 public function evidence(Request $request,EventRegistration $registration){
  abort_unless($registration->user_id===$request->user()->id && $request->user()->role->value==='mahasiswa',403);
  abort_unless($registration->status===RegistrationStatus::Approved && (now()->gte($registration->event->end_at) || $registration->event->status===EventStatus::Completed),403);
  $data=$request->validate(['evidence'=>['required','file','mimes:jpg,jpeg,png,webp,pdf','max:5120'],'description'=>['nullable','string','max:2000']]);
  $existing=$registration->attendanceVerification;
  abort_if($existing && $existing->verification_status!==VerificationStatus::Rejected,403,'Bukti kehadiran sedang diproses atau sudah disetujui.');
  $path=$request->file('evidence')->store('evidence','local');
  if($existing){Storage::disk('local')->delete($existing->evidence_file);$existing->update(['evidence_file'=>$path,'evidence_description'=>$data['description']??null,'verification_status'=>VerificationStatus::Pending,'verified_by'=>null,'verified_at'=>null,'verification_notes'=>null]);}
  else $registration->attendanceVerification()->create(['evidence_file'=>$path,'evidence_description'=>$data['description']??null,'verification_status'=>VerificationStatus::Pending]);
  return back()->with('success','Bukti kehadiran berhasil diunggah.');
 }
 public function download(AttendanceVerification $verification){abort_unless(request()->user()->can('viewEvidence',$verification),403);abort_unless(Storage::disk('local')->exists($verification->evidence_file),404);return Storage::disk('local')->download($verification->evidence_file);}
}
