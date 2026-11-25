<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">Master User</h2>
    </x-slot>
    <div class="max-w-7xl mx-auto px-4 py-8 space-y-6">
        <x-notice />
        <div class="flex flex-wrap justify-between items-center gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-900">Kelola Pengguna</h1>
                <p class="text-sm text-slate-500">Seluruh prodi · pengelolaan akun dan hak akses</p>
            </div><a href="{{ route('master.users.create') }}"
                class="bg-blue-700 text-white px-5 py-3 rounded-xl font-semibold">+ Tambah User</a>
        </div>
        <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 bg-white border p-4 rounded-2xl">
            <input class="border-slate-200 rounded-xl" name="q" value="{{ request('q') }}"
                placeholder="Cari nama, email, NIM">
            <select class="border-slate-200 rounded-xl" name="role">
                <option value="">Semua role</option>
                @foreach (['super_admin' => 'Super Admin', 'admin' => 'Admin Prodi', 'mahasiswa' => 'Mahasiswa'] as $value => $label)
                    <option value="{{ $value }}" @selected(request('role') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <select class="border-slate-200 rounded-xl" name="study_program_id">
                <option value="">Semua prodi</option>
                @foreach ($programs as $program)
                    <option value="{{ $program->id }}" @selected(request('study_program_id') == $program->id)>{{ $program->code }} -
                        {{ $program->name }}</option>
                @endforeach
            </select>
            <select class="border-slate-200 rounded-xl" name="status">
                <option value="">Semua status</option>
                <option value="active" @selected(request('status') === 'active')>Aktif</option>
                <option value="inactive" @selected(request('status') === 'inactive')>Nonaktif</option>
            </select>
            <button class="bg-slate-900 text-white rounded-xl px-4 py-2">Terapkan Filter</button>
        </form>
        <div class="bg-white border rounded-2xl overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        @foreach (['Nama / Email', 'Prodi', 'NIM / Angkatan', 'Role', 'Status', 'Aksi'] as $heading)
                            <th class="text-left py-4 px-5 whitespace-nowrap">{{ $heading }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr>
                            <td class="p-5">
                                <p class="font-bold">{{ $user->name }}</p>
                                <p class="text-slate-500 text-xs">{{ $user->email }}</p>
                            </td>
                            <td class="p-5">{{ $user->studyProgram?->code }}</td>
                            <td class="p-5">{{ $user->student_number ?? '—' }}<span
                                    class="text-slate-500">{{ $user->angkatan ? ' / ' . $user->angkatan : '' }}</span>
                            </td>
                            <td class="p-5 whitespace-nowrap">
                                {{ ['super_admin' => 'Super Admin', 'admin' => 'Admin Prodi', 'mahasiswa' => 'Mahasiswa'][$user->role->value] ?? 'Tidak Dikenal' }}
                            </td>
                            <td class="p-5"><span
                                    class="rounded-full px-3 py-1 text-xs font-bold {{ $user->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                            </td>
                            <td class="p-5">
                                <div class="flex flex-wrap gap-2 items-center"><a
                                        class="px-3 py-2 bg-slate-100 rounded-lg"
                                        href="{{ route('master.users.edit', $user) }}">Edit</a>
                                    <form method="POST" action="{{ route('master.users.status', $user) }}"
                                        onsubmit="return confirm('Yakin ingin {{ $user->is_active ? 'menonaktifkan' : 'mengaktifkan' }} akun ini?')">
                                        @csrf @method('PATCH')<button
                                            class="px-3 py-2 rounded-lg {{ $user->is_active ? 'text-rose-700 bg-rose-50' : 'text-emerald-700 bg-emerald-50' }}"
                                            @disabled($user->id === auth()->id())>{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty<tr>
                            <td colspan="6" class="p-8 text-center text-slate-500">Tidak ada user sesuai filter.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div>{{ $users->links() }}</div>
    </div>
</x-app-layout>
