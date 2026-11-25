<?php
namespace App\Http\Controllers;
use App\Enums\{AudienceScope,UserRole};
use App\Http\Requests\SaveEventRequest;
use App\Models\{Event,EventCategory,StudyProgram};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
class EventController extends Controller {
 public function index(Request $request){
  $user=$request->user();
  $query=Event::with(['category','organizerProgram','creator'])->withCount(['registrations as approved_count'=>fn($q)=>$q->where('status','approved')]);
  if($user->role===UserRole::Admin)$query->where(fn($q)=>$q->where('organizer_program_id',$user->study_program_id)->orWhere('creator_id',$user->id));
  else $query->where('creator_id',$user->id);
  return view('events.manage',['events'=>$query->latest()->paginate(12),'canCreate'=>$user->can('create',Event::class)]);
 }
 public function create(){abort_unless(auth()->user()->can('create',Event::class),403);return view('events.form',['event'=>new Event,'categories'=>EventCategory::orderBy('name')->get(),'programs'=>StudyProgram::orderBy('code')->get()]);}
 public function store(SaveEventRequest $request){$this->save($request,new Event);return redirect()->route('events.index')->with('success','Event berhasil dibuat.');}
 public function edit(Event $event){$this->authorizeEvent($event);return view('events.form',['event'=>$event,'categories'=>EventCategory::orderBy('name')->get(),'programs'=>StudyProgram::orderBy('code')->get()]);}
 public function update(SaveEventRequest $request,Event $event){$this->authorizeEvent($event);$this->save($request,$event);return redirect()->route('events.index')->with('success','Event berhasil diperbarui.');}
 public function cancel(Event $event){$this->authorizeEvent($event);$event->update(['status'=>'cancelled']);return back()->with('success','Event dibatalkan.');}
 private function authorizeEvent(Event $event): void {abort_unless(auth()->user()->can('update',$event),403);}
 private function save(SaveEventRequest $request,Event $event): void {
  $user=$request->user();abort_unless($event->exists?$user->can('update',$event):$user->can('create',Event::class),403);
  $data=$request->validated();
  $organizer=$event->exists?$event->organizer_program_id:$user->study_program_id;
  if(!$event->exists && $user->role!==UserRole::Admin && !$user->creatorAccesses()->where('is_active',true)->where('study_program_id',$organizer)->exists())abort(403);
  if($user->role===UserRole::Admin && !$event->exists)$organizer=$user->study_program_id;
  if($event->exists && $data['status']!==$event->status->value){
   $allowed=['draft'=>['published','cancelled'],'published'=>['closed','cancelled'],'closed'=>['completed','cancelled'],'completed'=>[],'cancelled'=>[]];
   if(!in_array($data['status'],$allowed[$event->status->value]??[],true))throw ValidationException::withMessages(['status'=>'Perubahan status event tidak sesuai alur.']);
  }
  $targets=$data['audience_scope']==='selected'?array_values(array_unique(array_merge($data['target_programs']??[],[$organizer]))):[];
  unset($data['target_programs']);
  if($data['reward_type']==='jam_plus')$data['soft_skill_points_offer']=null;
  if($data['reward_type']==='soft_skill')$data['jam_plus_offer']=null;
  if($request->hasFile('poster'))$data['poster']=$request->file('poster')->store('posters','public');
  DB::transaction(function()use($event,$data,$user,$organizer,$targets){
   if(!$event->exists){$data['creator_id']=$user->id;$data['organizer_program_id']=$organizer;}
   $event->fill($data)->save();
   $event->targets()->delete();
   foreach($targets as $id)$event->targets()->create(['study_program_id'=>$id]);
  });
 }
}
