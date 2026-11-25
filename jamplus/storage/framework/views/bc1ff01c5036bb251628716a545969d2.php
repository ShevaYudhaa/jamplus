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
  <?php $__env->slot('header', null, []); ?> <h2 class="text-xl font-bold"><?php echo e($editedUser?'Edit User':'Tambah User'); ?></h2> <?php $__env->endSlot(); ?>
 <div class="max-w-3xl mx-auto px-4 py-8"><?php if (isset($component)) { $__componentOriginala37bee3be1b7b9366ae2ff14e78e37db = $component; } ?>
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
<?php endif; ?><a href="<?php echo e(route('master.users.index')); ?>" class="text-blue-700 text-sm font-semibold">← Kembali ke Master User</a>
  <form method="POST" action="<?php echo e($editedUser?route('master.users.update',$editedUser):route('master.users.store')); ?>" class="bg-white border rounded-2xl p-6 mt-5 space-y-5"><?php echo csrf_field(); ?> <?php if($editedUser): ?><?php echo method_field('PUT'); ?><?php endif; ?>
   <div class="grid sm:grid-cols-2 gap-5">
    <label class="block text-sm font-semibold">Nama lengkap<input required maxlength="100" name="name" value="<?php echo e(old('name',$editedUser?->name)); ?>" class="w-full mt-2 border-slate-200 rounded-xl"></label>
    <label class="block text-sm font-semibold">Email<input required type="email" maxlength="150" name="email" value="<?php echo e(old('email',$editedUser?->email)); ?>" class="w-full mt-2 border-slate-200 rounded-xl"></label>
    <label class="block text-sm font-semibold">Role<select required name="role" class="w-full mt-2 border-slate-200 rounded-xl"><?php $__currentLoopData = ['mahasiswa'=>'Mahasiswa','admin'=>'Admin Prodi','super_admin'=>'Super Admin']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>" <?php if(old('role',$editedUser?->role?->value ?? 'mahasiswa')===$value): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
    <label class="block text-sm font-semibold">Program Studi<select required name="study_program_id" class="w-full mt-2 border-slate-200 rounded-xl"><option value="">Pilih prodi</option><?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($program->id); ?>" <?php if(old('study_program_id',$editedUser?->study_program_id)==$program->id): echo 'selected'; endif; ?>><?php echo e($program->code); ?> — <?php echo e($program->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
    <label class="block text-sm font-semibold">NIM (khusus mahasiswa)<input maxlength="30" name="student_number" value="<?php echo e(old('student_number',$editedUser?->student_number)); ?>" class="w-full mt-2 border-slate-200 rounded-xl"></label>
    <label class="block text-sm font-semibold">Angkatan (khusus mahasiswa)<input type="number" min="1900" max="2100" name="angkatan" value="<?php echo e(old('angkatan',$editedUser?->angkatan)); ?>" class="w-full mt-2 border-slate-200 rounded-xl"></label>
    <label class="block text-sm font-semibold">Password <?php echo e($editedUser?'(kosongkan jika tidak diubah)':''); ?><input type="password" name="password" <?php echo e($editedUser?'':'required'); ?> minlength="8" autocomplete="new-password" class="w-full mt-2 border-slate-200 rounded-xl"></label>
    <label class="block text-sm font-semibold">Konfirmasi Password<input type="password" name="password_confirmation" <?php echo e($editedUser?'':'required'); ?> minlength="8" autocomplete="new-password" class="w-full mt-2 border-slate-200 rounded-xl"></label>
   </div>
   <?php if($errors->any()): ?><div class="bg-rose-50 text-rose-700 p-4 rounded-xl"><ul class="list-disc pl-5"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></div><?php endif; ?>
   <div class="flex justify-end"><button class="bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold"><?php echo e($editedUser?'Simpan Perubahan':'Buat Akun'); ?></button></div>
  </form>
  <?php if($editedUser): ?><form method="POST" action="<?php echo e(route('master.users.password',$editedUser)); ?>" onsubmit="return confirm('Reset password pengguna ini?')" class="mt-6 bg-white border rounded-2xl p-6 space-y-4"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?><h3 class="font-bold">Reset Password</h3><p class="text-xs text-slate-500">Tentukan password baru minimal 8 karakter.</p><input required name="password" type="password" minlength="8" autocomplete="new-password" placeholder="Password baru" class="border-slate-200 rounded-xl w-full"><input required name="password_confirmation" type="password" minlength="8" autocomplete="new-password" placeholder="Konfirmasi password" class="border-slate-200 rounded-xl w-full"><button class="bg-slate-900 text-white rounded-xl px-5 py-3">Reset Password</button></form><?php endif; ?>
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
<?php /**PATH C:\xampp\htdocs\Sistem Informasi Monitoring Jam Plus dan Soft Skill Mahasiswa\jamplus\resources\views/master/users/form.blade.php ENDPATH**/ ?>