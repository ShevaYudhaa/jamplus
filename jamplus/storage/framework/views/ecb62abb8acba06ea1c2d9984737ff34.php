<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="text-xl font-bold">Master User</h2>
     <?php $__env->endSlot(); ?>
    <div class="max-w-7xl mx-auto px-4 py-8 space-y-6">
        <?php if (isset($component)) { $__componentOriginala37bee3be1b7b9366ae2ff14e78e37db = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala37bee3be1b7b9366ae2ff14e78e37db = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.notice','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('notice'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala37bee3be1b7b9366ae2ff14e78e37db)): ?>
<?php $attributes = $__attributesOriginala37bee3be1b7b9366ae2ff14e78e37db; ?>
<?php unset($__attributesOriginala37bee3be1b7b9366ae2ff14e78e37db); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala37bee3be1b7b9366ae2ff14e78e37db)): ?>
<?php $component = $__componentOriginala37bee3be1b7b9366ae2ff14e78e37db; ?>
<?php unset($__componentOriginala37bee3be1b7b9366ae2ff14e78e37db); ?>
<?php endif; ?>
        <div class="flex flex-wrap justify-between items-center gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-900">Kelola Pengguna</h1>
                <p class="text-sm text-slate-500">Seluruh prodi · pengelolaan akun dan hak akses</p>
            </div><a href="<?php echo e(route('master.users.create')); ?>"
                class="bg-blue-700 text-white px-5 py-3 rounded-xl font-semibold">+ Tambah User</a>
        </div>
        <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 bg-white border p-4 rounded-2xl">
            <input class="border-slate-200 rounded-xl" name="q" value="<?php echo e(request('q')); ?>"
                placeholder="Cari nama, email, NIM">
            <select class="border-slate-200 rounded-xl" name="role">
                <option value="">Semua role</option>
                <?php $__currentLoopData = ['super_admin' => 'Super Admin', 'admin' => 'Admin Prodi', 'mahasiswa' => 'Mahasiswa']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($value); ?>" <?php if(request('role') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <select class="border-slate-200 rounded-xl" name="study_program_id">
                <option value="">Semua prodi</option>
                <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($program->id); ?>" <?php if(request('study_program_id') == $program->id): echo 'selected'; endif; ?>><?php echo e($program->code); ?> -
                        <?php echo e($program->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <select class="border-slate-200 rounded-xl" name="status">
                <option value="">Semua status</option>
                <option value="active" <?php if(request('status') === 'active'): echo 'selected'; endif; ?>>Aktif</option>
                <option value="inactive" <?php if(request('status') === 'inactive'): echo 'selected'; endif; ?>>Nonaktif</option>
            </select>
            <button class="bg-slate-900 text-white rounded-xl px-4 py-2">Terapkan Filter</button>
        </form>
        <div class="bg-white border rounded-2xl overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <?php $__currentLoopData = ['Nama / Email', 'Prodi', 'NIM / Angkatan', 'Role', 'Status', 'Aksi']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $heading): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th class="text-left py-4 px-5 whitespace-nowrap"><?php echo e($heading); ?></th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="p-5">
                                <p class="font-bold"><?php echo e($user->name); ?></p>
                                <p class="text-slate-500 text-xs"><?php echo e($user->email); ?></p>
                            </td>
                            <td class="p-5"><?php echo e($user->studyProgram?->code); ?></td>
                            <td class="p-5"><?php echo e($user->student_number ?? '—'); ?><span
                                    class="text-slate-500"><?php echo e($user->angkatan ? ' / ' . $user->angkatan : ''); ?></span>
                            </td>
                            <td class="p-5 whitespace-nowrap">
                                <?php echo e(['super_admin' => 'Super Admin', 'admin' => 'Admin Prodi', 'mahasiswa' => 'Mahasiswa'][$user->role->value] ?? 'Tidak Dikenal'); ?>

                            </td>
                            <td class="p-5"><span
                                    class="rounded-full px-3 py-1 text-xs font-bold <?php echo e($user->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700'); ?>"><?php echo e($user->is_active ? 'Aktif' : 'Nonaktif'); ?></span>
                            </td>
                            <td class="p-5">
                                <div class="flex flex-wrap gap-2 items-center"><a
                                        class="px-3 py-2 bg-slate-100 rounded-lg"
                                        href="<?php echo e(route('master.users.edit', $user)); ?>">Edit</a>
                                    <form method="POST" action="<?php echo e(route('master.users.status', $user)); ?>"
                                        onsubmit="return confirm('Yakin ingin <?php echo e($user->is_active ? 'menonaktifkan' : 'mengaktifkan'); ?> akun ini?')">
                                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?><button
                                            class="px-3 py-2 rounded-lg <?php echo e($user->is_active ? 'text-rose-700 bg-rose-50' : 'text-emerald-700 bg-emerald-50'); ?>"
                                            <?php if($user->id === auth()->id()): echo 'disabled'; endif; ?>><?php echo e($user->is_active ? 'Nonaktifkan' : 'Aktifkan'); ?></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr>
                            <td colspan="6" class="p-8 text-center text-slate-500">Tidak ada user sesuai filter.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div><?php echo e($users->links()); ?></div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\Sistem Informasi Monitoring Jam Plus dan Soft Skill Mahasiswa\jamplus\resources\views/master/users/index.blade.php ENDPATH**/ ?>