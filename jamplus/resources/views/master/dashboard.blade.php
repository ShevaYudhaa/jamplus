<x-app-layout>
 <x-slot name="header"><h2 class="text-xl font-bold">Dashboard Super Admin</h2></x-slot>
 <div class="max-w-7xl mx-auto px-4 py-8">
  <x-notice/>
  <section class="bg-slate-950 text-white rounded-3xl p-8 mb-7"><p class="text-blue-300 uppercase text-xs font-bold tracking-widest">Administrasi Sistem</p><h1 class="text-3xl font-black mt-3">Selamat datang, {{ auth()->user()->name }}</h1><p class="text-slate-300 mt-2">Kelola master pengguna seluruh program studi dari satu tempat.</p></section>
  <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-7">@foreach(['users'=>'Total Pengguna','students'=>'Mahasiswa','admins'=>'Admin Prodi','inactive'=>'Nonaktif'] as $key=>$label)<div class="bg-white border rounded-2xl p-6"><p class="text-sm text-slate-500">{{$label}}</p><p class="text-3xl font-black mt-2">{{$counts[$key]}}</p></div>@endforeach</div>
  <a href="{{route('master.users.index')}}" class="inline-block bg-blue-700 text-white rounded-xl px-6 py-3 font-semibold hover:bg-blue-800">Buka Master User</a>
 </div>
</x-app-layout>
