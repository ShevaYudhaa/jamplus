<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class SaveEventRequest extends FormRequest {
 public function authorize(): bool {return true;}
 public function rules(): array { return [
  'title'=>['required','string','max:200'], 'category_id'=>['required','exists:event_categories,id'],
  'description'=>['nullable','string'], 'location'=>['nullable','string','max:200'],
  'start_at'=>['required','date'], 'end_at'=>['required','date','after_or_equal:start_at'],
  'registration_deadline'=>['nullable','date','before_or_equal:start_at'], 'quota'=>['nullable','integer','min:1'],
  'reward_type'=>['required',Rule::in(['jam_plus','soft_skill','both'])],
  'jam_plus_offer'=>['nullable','numeric','min:0','max:9999.99'],
  'soft_skill_points_offer'=>['nullable','numeric','min:0','max:9999.99'],
  'audience_scope'=>['required',Rule::in(['all','selected'])],
  'target_programs'=>['array'], 'target_programs.*'=>['integer','exists:study_programs,id'],
  'poster'=>['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
  'status'=>['required',Rule::in(['draft','published','closed','completed','cancelled'])],
 ]; }
 public function withValidator($validator): void {$validator->after(function($validator){
  $kind=$this->input('reward_type'); $j=(float)$this->input('jam_plus_offer',0);$s=(float)$this->input('soft_skill_points_offer',0);
  if(in_array($kind,['jam_plus','both']) && $j<=0)$validator->errors()->add('jam_plus_offer','Jam Plus wajib lebih dari nol.');
  if(in_array($kind,['soft_skill','both']) && $s<=0)$validator->errors()->add('soft_skill_points_offer','Poin Soft Skill wajib lebih dari nol.');
  if($kind==='jam_plus' && $s>0)$validator->errors()->add('soft_skill_points_offer','Poin Soft Skill harus kosong untuk reward Jam Plus.');
  if($kind==='soft_skill' && $j>0)$validator->errors()->add('jam_plus_offer','Jam Plus harus kosong untuk reward Soft Skill.');
 });}
}
