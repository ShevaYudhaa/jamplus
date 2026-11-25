<x-app-layout>
 <x-slot name="header"><h2 class="text-xl font-bold">{{$editedUser?'Edit User':'Tambah User'}}</h2></x-slot>
 <div class="max-w-3xl mx-auto px-4 py-8"><x-notice/><a href="{{route('master.users.index')}}" class="text-blue-700 text-sm font-semibold">← Kembali ke Master User</a>
  <form method="POST" action="{{$editedUser?route('master.users.update',$editedUser):route('master.users.store')}}" class="bg-white border rounded-2xl p-6 mt-5 space-y-5">@csrf @if($editedUser)@method('PUT')@endif
   <div class="grid sm:grid-cols-2 gap-5">
    <label class="block text-sm font-semibold">Nama lengkap<input required maxlength="100" name="name" value="{{old('name',$editedUser?->name)}}" class="w-full mt-2 border-slate-200 rounded-xl"></label>
    <label class="block text-sm font-semibold">Email<input required type="email" maxlength="150" name="email" value="{{old('email',$editedUser?->email)}}" class="w-full mt-2 border-slate-200 rounded-xl"></label>
    <label class="block text-sm font-semibold">Role<select required name="role" class="w-full mt-2 border-slate-200 rounded-xl">@foreach(['mahasiswa'=>'Mahasiswa','admin'=>'Admin Prodi','super_admin'=>'Super Admin'] as $value=>$label)<option value="{{$value}}" @selected(old('role',$editedUser?->role?->value ?? 'mahasiswa')===$value)>{{$label}}</option>@endforeach</select></label>
    <label class="block text-sm font-semibold">Program Studi<select required name="study_program_id" class="w-full mt-2 border-slate-200 rounded-xl"><option value="">Pilih prodi</option>@foreach($programs as $program)<option value="{{$program->id}}" @selected(old('study_program_id',$editedUser?->study_program_id)==$program->id)>{{$program->code}} — {{$program->name}}</option>@endforeach</select></label>
    <label class="block text-sm font-semibold">NIM (khusus mahasiswa)<input maxlength="30" name="student_number" value="{{old('student_number',$editedUser?->student_number)}}" class="w-full mt-2 border-slate-200 rounded-xl"></label>
    <label class="block text-sm font-semibold">Angkatan (khusus mahasiswa)<input type="number" min="1900" max="2100" name="angkatan" value="{{old('angkatan',$editedUser?->angkatan)}}" class="w-full mt-2 border-slate-200 rounded-xl"></label>
    <label class="block text-sm font-semibold">Password {{$editedUser?'(kosongkan jika tidak diubah)':''}}<input type="password" name="password" {{$editedUser?'':'required'}} minlength="8" autocomplete="new-password" class="w-full mt-2 border-slate-200 rounded-xl"></label>
    <label class="block text-sm font-semibold">Konfirmasi Password<input type="password" name="password_confirmation" {{$editedUser?'':'required'}} minlength="8" autocomplete="new-password" class="w-full mt-2 border-slate-200 rounded-xl"></label>
   </div>
   @if($errors->any())<div class="bg-rose-50 text-rose-700 p-4 rounded-xl"><ul class="list-disc pl-5">@foreach($errors->all() as $error)<li>{{$error}}</li>@endforeach</ul></div>@endif
   <div class="flex justify-end"><button class="bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold">{{$editedUser?'Simpan Perubahan':'Buat Akun'}}</button></div>
  </form>
  @if($editedUser)<form method="POST" action="{{route('master.users.password',$editedUser)}}" onsubmit="return confirm('Reset password pengguna ini?')" class="mt-6 bg-white border rounded-2xl p-6 space-y-4">@csrf @method('PATCH')<h3 class="font-bold">Reset Password</h3><p class="text-xs text-slate-500">Tentukan password baru minimal 8 karakter.</p><input required name="password" type="password" minlength="8" autocomplete="new-password" placeholder="Password baru" class="border-slate-200 rounded-xl w-full"><input required name="password_confirmation" type="password" minlength="8" autocomplete="new-password" placeholder="Konfirmasi password" class="border-slate-200 rounded-xl w-full"><button class="bg-slate-900 text-white rounded-xl px-5 py-3">Reset Password</button></form>@endif
 </div>
</x-app-layout>
