<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\{StudyProgram, User};
use Illuminate\Http\{Request,RedirectResponse};
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    private function authorizeSuperAdmin(): void
    {
        abort_unless(auth()->user()?->role === UserRole::SuperAdmin && auth()->user()->is_active, 403);
    }

    public function dashboard(): View
    {
        $this->authorizeSuperAdmin();
        return view('master.dashboard', [
            'counts' => [
                'users' => User::count(),
                'students' => User::where('role', UserRole::Mahasiswa->value)->count(),
                'admins' => User::where('role', UserRole::Admin->value)->count(),
                'inactive' => User::where('is_active', false)->count(),
            ],
        ]);
    }

    public function index(Request $request): View
    {
        $this->authorizeSuperAdmin();
        $request->validate(['role' => ['nullable', Rule::in(array_column(UserRole::cases(), 'value'))],
            'status' => ['nullable', Rule::in(['active', 'inactive'])], 'study_program_id' => ['nullable', 'integer', 'exists:study_programs,id']]);
        $users = User::query()->with('studyProgram')
            ->when($request->filled('q'), fn ($q) => $q->where(fn ($sub) => $sub
                ->where('name', 'like', '%'.$request->q.'%')
                ->orWhere('email', 'like', '%'.$request->q.'%')
                ->orWhere('student_number', 'like', '%'.$request->q.'%')))
            ->when($request->filled('role'), fn ($q) => $q->where('role', $request->role))
            ->when($request->filled('status'), fn ($q) => $q->where('is_active', $request->status === 'active'))
            ->when($request->filled('study_program_id'), fn ($q) => $q->where('study_program_id', $request->study_program_id))
            ->orderBy('name')->paginate(15)->withQueryString();
        return view('master.users.index', ['users' => $users, 'programs' => StudyProgram::orderBy('code')->get()]);
    }

    public function create(): View
    {
        $this->authorizeSuperAdmin();
        return view('master.users.form', ['editedUser' => null, 'programs' => StudyProgram::orderBy('code')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeSuperAdmin();
        $data = $this->validated($request);
        User::create($data);
        return redirect()->route('master.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user): View
    {
        $this->authorizeSuperAdmin();
        return view('master.users.form', ['editedUser' => $user, 'programs' => StudyProgram::orderBy('code')->get()]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $this->authorizeSuperAdmin();
        $data = $this->validated($request, $user);
        if ($user->id === auth()->id() && $data['role'] !== UserRole::SuperAdmin->value) {
            return back()->withErrors(['role' => 'Tidak bisa menurunkan role akun sendiri.'])->withInput();
        }
        DB::transaction(function () use ($user, $data) {
            $locked = User::whereKey($user->id)->lockForUpdate()->firstOrFail();
            if ($locked->role === UserRole::SuperAdmin && $data['role'] !== UserRole::SuperAdmin->value
                && User::where('role', UserRole::SuperAdmin->value)->where('is_active', true)->count() <= 1 && $locked->is_active) {
                abort(422, 'Tidak boleh menghilangkan super admin aktif terakhir.');
            }
            $locked->update($data);
        });
        return redirect()->route('master.users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function status(User $user): RedirectResponse
    {
        $this->authorizeSuperAdmin();
        abort_if($user->id === auth()->id(), 422, 'Tidak boleh menonaktifkan akun sendiri.');
        DB::transaction(function () use ($user) {
            $locked = User::whereKey($user->id)->lockForUpdate()->firstOrFail();
            if ($locked->is_active && $locked->role === UserRole::SuperAdmin
                && User::where('role', UserRole::SuperAdmin->value)->where('is_active', true)->count() <= 1) {
                abort(422, 'Tidak boleh menonaktifkan super admin aktif terakhir.');
            }
            $locked->update(['is_active' => !$locked->is_active]);
        });
        return back()->with('success', 'Status pengguna berhasil diubah.');
    }

    public function password(Request $request, User $user): RedirectResponse
    {
        $this->authorizeSuperAdmin();
        $data = $request->validate(['password' => ['required', 'string', 'min:8', 'confirmed']]);
        $user->update(['password' => $data['password']]);
        return back()->with('success', 'Password berhasil direset.');
    }

    private function validated(Request $request, ?User $user = null): array
    {
        $data = $request->validate([
            'study_program_id' => ['required', 'exists:study_programs,id'],
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($user?->id)],
            'role' => ['required', Rule::in(array_column(UserRole::cases(), 'value'))],
            'student_number' => ['nullable', 'string', 'max:30', Rule::unique('users', 'student_number')->ignore($user?->id)],
            'angkatan' => ['nullable', 'integer', 'between:1900,2100'],
            'password' => [$user ? 'nullable' : 'required', 'string', 'min:8', 'confirmed'],
        ]);
        if ($data['role'] === UserRole::Mahasiswa->value) {
            if (empty($data['student_number']) || empty($data['angkatan'])) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'student_number' => 'NIM dan angkatan wajib untuk mahasiswa.',
                ]);
            }
        } else {
            $data['student_number'] = null;
            $data['angkatan'] = null;
        }
        if (empty($data['password'])) unset($data['password']);
        return $data;
    }
}
