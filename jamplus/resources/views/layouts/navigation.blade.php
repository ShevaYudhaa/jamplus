<nav x-data="{ open: false }" class="bg-white border-b border-slate-200 shadow-sm">
 <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
  <div class="flex justify-between items-center min-h-20 gap-4">
   <a href="{{ route('dashboard') }}" class="flex items-center gap-3 shrink-0"><span class="flex items-center justify-center rounded-2xl bg-blue-700 text-white font-black text-xl h-11 w-11">J+</span><span class="font-extrabold tracking-tight text-xl text-slate-900">JAM<span class="text-blue-600">PLUS</span></span></a>
   <div class="hidden lg:flex items-center gap-5 text-sm font-semibold text-slate-600">
    <a class="hover:text-blue-700 {{ request()->routeIs('dashboard')?'text-blue-700':'' }}" href="{{route('dashboard')}}">Dasbor</a>
    @if(auth()->user()->role->value==='super_admin')
     <a class="hover:text-blue-700" href="{{route('master.users.index')}}">Master User</a>
    @elseif(auth()->user()->role->value==='mahasiswa')
     <a class="hover:text-blue-700" href="{{route('browse')}}">Jelajah Event</a><a class="hover:text-blue-700" href="{{route('history')}}">Riwayat Saya</a><a class="hover:text-blue-700" href="{{route('progress')}}">Progres Saya</a>
    @else
     <a class="hover:text-blue-700" href="{{route('admin.pending')}}">Pending</a><a class="hover:text-blue-700" href="{{route('admin.students')}}">Mahasiswa</a><a class="hover:text-blue-700" href="{{route('admin.access')}}">Akses Creator</a><a class="hover:text-blue-700" href="{{route('admin.categories')}}">Kategori</a>
    @endif
    @can('create',App\Models\Event::class)<a class="hover:text-blue-700" href="{{route('events.index')}}">Kelola Event</a>@endcan
   </div>
   <div class="hidden lg:flex items-center gap-4"><div class="text-right"><div class="text-sm font-semibold text-slate-900">{{auth()->user()->name}}</div><div class="text-xs text-slate-500">{{auth()->user()->studyProgram->code}}</div></div><form method="POST" action="{{route('logout')}}">@csrf<button class="rounded-xl border border-slate-200 px-3 py-2 text-sm hover:bg-slate-50">Keluar</button></form></div>
   <button class="lg:hidden text-slate-700 p-2" @click="open=!open" aria-label="Buka menu">☰</button>
  </div>
  <div class="lg:hidden pb-4 flex flex-col gap-3 text-sm" x-show="open" x-cloak>
   <a href="{{route('dashboard')}}">Dasbor</a>
   @if(auth()->user()->role->value==='super_admin')<a href="{{route('master.users.index')}}">Master User</a>@elseif(auth()->user()->role->value==='mahasiswa')<a href="{{route('browse')}}">Jelajah Event</a><a href="{{route('history')}}">Riwayat Saya</a><a href="{{route('progress')}}">Progres Saya</a>@else<a href="{{route('admin.pending')}}">Pending</a><a href="{{route('admin.students')}}">Mahasiswa</a><a href="{{route('admin.access')}}">Akses Creator</a><a href="{{route('admin.categories')}}">Kategori</a>@endif
   @can('create',App\Models\Event::class)<a href="{{route('events.index')}}">Kelola Event</a>@endcan
   <form method="POST" action="{{route('logout')}}">@csrf<button>Keluar</button></form>
  </div>
 </div>
</nav>
