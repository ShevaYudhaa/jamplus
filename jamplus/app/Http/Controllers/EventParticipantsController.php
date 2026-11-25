<?php
namespace App\Http\Controllers;
use App\Models\{Event,EventRegistration,AttendanceVerification};
use App\Services\EventWorkflowService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class EventParticipantsController extends Controller {
 public function index(Event $event){abort_unless(request()->user()->can('manage',$event),403);return view('events.participants',['event'=>$event,'registrations'=>$event->registrations()->with(['user','attendanceVerification'])->latest()->paginate(20)]);}
 public function registration(Request $request,EventRegistration $registration,EventWorkflowService $service){abort_unless($request->user()->can('manage',$registration->event),403);$data=$request->validate(['action'=>['required',Rule::in(['approve','reject'])],'notes'=>['required_if:action,reject','nullable','string','max:2000']]);$service->decideRegistration($registration,$request->user(),$data['action']==='approve',$data['notes']??null);return back()->with('success','Pendaftaran diproses.');}
 public function verification(Request $request,AttendanceVerification $verification,EventWorkflowService $service){abort_unless($request->user()->can('manage',$verification),403);$data=$request->validate(['action'=>['required',Rule::in(['approve','reject'])],'notes'=>['nullable','string','max:2000']]);$service->verify($verification,$request->user(),$data['action']==='approve',$data['notes']??null);return back()->with('success','Verifikasi disimpan dan reward disinkronkan.');}
}
