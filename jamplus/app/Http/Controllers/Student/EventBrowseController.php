<?php
namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;
use App\Models\{Event,EventCategory};
use Illuminate\Http\Request;
class EventBrowseController extends Controller {
 public function index(Request $request){
  $user=$request->user();$events=Event::query()->with(['category','organizerProgram'])->withCount(['registrations as approved_count'=>fn($q)=>$q->where('status','approved')])->where('status','published')
  ->where(fn($q)=>$q->where('audience_scope','all')->orWhereHas('targets',fn($t)=>$t->where('study_program_id',$user->study_program_id)))
  ->when($request->filled('q'),fn($q)=>$q->where(fn($s)=>$s->where('title','like','%'.$request->q.'%')->orWhere('description','like','%'.$request->q.'%')))
  ->when($request->filled('category'),fn($q)=>$q->where('category_id',$request->category))
  ->when($request->filled('reward'),fn($q)=>$q->where('reward_type',$request->reward))
  ->orderBy('start_at')->paginate(9)->withQueryString();
  return view('student.home',['events'=>$events,'categories'=>EventCategory::orderBy('name')->get()]);
 }
 public function show(Event $event){$user=request()->user();abort_unless($event->status->value==='published' || $user->can('update',$event) || $event->registrations()->where('user_id',$user->id)->exists(),404);if($event->status->value==='published' && $event->audience_scope->value==='selected' && !$event->targets()->where('study_program_id',$user->study_program_id)->exists() && !$user->can('update',$event) && !$event->registrations()->where('user_id',$user->id)->exists())abort(403);$event->load(['category','organizerProgram','creator']);$registration=$event->registrations()->where('user_id',$user->id)->first();$approved=$event->registrations()->where('status','approved')->count();return view('student.detail',compact('event','registration','approved'));}
}
