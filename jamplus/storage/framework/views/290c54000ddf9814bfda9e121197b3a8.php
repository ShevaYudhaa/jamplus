<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php $__env->slot('header', null, []); ?> <h2 class="text-xl font-bold">Riwayat Pendaftaran</h2> <?php $__env->endSlot(); ?><div class="max-w-5xl mx-auto px-4 py-8"><?php if (isset($component)) { $__componentOriginala37bee3be1b7b9366ae2ff14e78e37db = $component; } ?>
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
<?php endif; ?><h1 class="text-2xl font-black mb-6">Event yang Kamu Ikuti</h1><div class="space-y-4"><?php $__empty_1 = true; $__currentLoopData = $registrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $registration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><div class="bg-white border border-slate-200 rounded-2xl p-6"><div class="flex flex-wrap justify-between gap-4"><div><h2 class="font-bold text-lg"><?php echo e($registration->event->title); ?></h2><p class="text-slate-500 text-sm mt-1"><?php echo e($registration->event->start_at->translatedFormat('d M Y')); ?> · Status: <strong><?php echo e($registration->status->value); ?></strong></p><?php if($registration->rejection_notes): ?><p class="text-sm text-rose-600 mt-2">Alasan: <?php echo e($registration->rejection_notes); ?></p><?php endif; ?></div><a href="<?php echo e(route('browse.show',$registration->event)); ?>" class="text-blue-700 text-sm font-bold">Detail →</a></div><?php if($registration->status->value==='approved'): ?><div class="mt-5 border-t pt-4"><p class="text-sm text-slate-600 mb-3">Bukti kehadiran: <strong><?php echo e($registration->attendanceVerification?->verification_status->value??'Belum diunggah'); ?></strong></p><?php if($registration->attendanceVerification?->verification_notes): ?><p class="text-xs text-rose-600 mb-2">Catatan verifikasi: <?php echo e($registration->attendanceVerification->verification_notes); ?></p><?php endif; ?> <?php if((now()->gte($registration->event->end_at) || $registration->event->status->value==='completed') && (!$registration->attendanceVerification || $registration->attendanceVerification->verification_status->value==='rejected')): ?><form method="POST" enctype="multipart/form-data" action="<?php echo e(route('evidence.upload',$registration)); ?>" class="flex flex-wrap gap-3 items-center"><?php echo csrf_field(); ?><input required type="file" name="evidence" accept="image/*,.pdf" class="text-sm"><input name="description" placeholder="Keterangan (opsional)" class="rounded-lg border-slate-200 text-sm"><button class="px-4 py-2 bg-blue-700 text-white rounded-lg text-sm font-bold">Unggah Bukti</button></form><?php endif; ?></div><?php endif; ?></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><p class="text-slate-500 bg-white p-10 rounded-2xl">Belum ada pendaftaran.</p><?php endif; ?></div><div class="mt-6"><?php echo e($registrations->links()); ?></div></div> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\Sistem Informasi Monitoring Jam Plus dan Soft Skill Mahasiswa\jamplus\resources\views\student\history.blade.php ENDPATH**/ ?>