@props(['event'])
<a href="{{route('browse.show',$event)}}" class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300">
 <div class="h-44 relative bg-gradient-to-br from-blue-900 via-blue-700 to-sky-500 overflow-hidden">
  @if($event->poster)<img class="h-full w-full object-cover" src="{{asset('storage/'.$event->poster)}}" alt="Poster event">@else<div class="flex h-full items-center justify-center text-white/25 text-7xl font-black">J+</div>@endif
  <span class="absolute top-4 left-4 bg-white/95 text-blue-800 px-3 py-1 rounded-full text-xs font-bold">{{$event->category?->name}}</span>
 </div>
 <div class="p-5 flex flex-col flex-1 gap-3"><div class="text-xs font-bold uppercase tracking-wider text-blue-600">{{$event->organizerProgram?->name ?? 'Event Kampus'}}</div><h3 class="text-lg font-extrabold text-slate-900 leading-tight group-hover:text-blue-700 transition">{{$event->title}}</h3><p class="text-sm text-slate-500">📅 {{$event->start_at->translatedFormat('d M Y, H:i')}} WIB</p><p class="text-sm text-slate-500">📍 {{$event->location ?: 'Lokasi belum ditentukan'}}</p>
 <div class="mt-auto pt-3 flex flex-wrap gap-2"><span class="bg-blue-50 text-blue-800 px-3 py-1.5 rounded-lg text-xs font-bold">@if($event->jam_plus_offer) +{{(float)$event->jam_plus_offer}} Jam Plus @endif @if($event->soft_skill_points_offer) +{{(float)$event->soft_skill_points_offer}} Soft Skill @endif</span></div>
 <div class="border-t border-slate-100 pt-3 text-xs text-slate-500">{{$event->quota ? max(0,$event->quota-$event->approved_count).' kuota tersisa':'Tanpa batas kuota'}} <span class="float-right text-blue-700 font-semibold">Lihat detail →</span></div>
 </div>
</a>
