<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php $__env->slot('header', null, []); ?> <h2 class="text-xl font-bold">Akses Pembuat Acara</h2> <?php $__env->endSlot(); ?><div class="max-w-5xl mx-auto px-4 py-8"><?php if (isset($component)) { $__componentOriginala37bee3be1b7b9366ae2ff14e78e37db = $component; } ?>
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
<?php endif; ?><div class="bg-white p-6 rounded-2xl border mb-6"><h2 class="text-lg font-black mb-4">Beri / Aktifkan Akses</h2><form method="POST" action="<?php echo e(route('admin.access.grant')); ?>" class="flex flex-wrap gap-3"><?php echo csrf_field(); ?><select required name="user_id" class="rounded-xl border-slate-200 flex-1"><option value="">Pilih mahasiswa prodi</option><?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($student->id); ?>"><?php echo e($student->name); ?> (<?php echo e($student->student_number); ?>)</option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select><button class="rounded-xl bg-blue-700 text-white font-semibold px-5 py-3">Aktifkan</button></form></div><div class="bg-white border rounded-2xl divide-y"><?php $__empty_1 = true; $__currentLoopData = $accesses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $access): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><div class="p-5 flex justify-between gap-4 items-center"><div><strong><?php echo e($access->user->name); ?></strong><p class="text-xs text-slate-500"><?php echo e($access->is_active?'Aktif':'Dicabut'); ?> · <?php echo e($access->user->student_number); ?></p></div><?php if($access->is_active): ?><form method="POST" action="<?php echo e(route('admin.access.revoke',$access)); ?>" onsubmit="return confirm('Cabut akses pembuat acara?')"><?php echo csrf_field(); ?><button class="text-rose-600 font-semibold">Cabut akses</button></form><?php endif; ?></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><div class="p-6 text-slate-500">Belum ada pemegang akses.</div><?php endif; ?></div><div class="mt-6"><?php echo e($accesses->links()); ?></div></div> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\Sistem Informasi Monitoring Jam Plus dan Soft Skill Mahasiswa\jamplus\resources\views/admin/access.blade.php ENDPATH**/ ?>