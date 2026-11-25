<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php $__env->slot('header', null, []); ?> <h2 class="text-xl font-bold">Kelola Peserta</h2> <?php $__env->endSlot(); ?><div class="max-w-6xl mx-auto px-4 py-8"><?php if (isset($component)) { $__componentOriginala37bee3be1b7b9366ae2ff14e78e37db = $component; } ?>
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
<?php endif; ?><a href="<?php echo e(route('events.index')); ?>" class="text-blue-700 text-sm">← Kembali</a><h1 class="text-2xl font-black my-5"><?php echo e($event->title); ?></h1><div class="space-y-4"><?php $__empty_1 = true; $__currentLoopData = $registrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $registration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><div class="bg-white border rounded-2xl p-6"><div class="flex flex-wrap justify-between gap-4"><div><h3 class="font-extrabold"><?php echo e($registration->user->name); ?></h3><p class="text-sm text-slate-500"><?php echo e($registration->user->student_number); ?> · <?php echo e($registration->status->value); ?></p></div><?php if($registration->status->value==='pending'): ?><div class="flex flex-wrap gap-2"><form method="POST" action="<?php echo e(route('registrations.decide',$registration)); ?>"><?php echo csrf_field(); ?><input type="hidden" name="action" value="approve"><button class="bg-emerald-600 text-white rounded-lg px-4 py-2 text-sm">Setujui</button></form><form method="POST" action="<?php echo e(route('registrations.decide',$registration)); ?>" class="flex gap-2"><?php echo csrf_field(); ?><input type="hidden" name="action" value="reject"><input required name="notes" placeholder="Alasan penolakan" class="rounded-lg border-slate-200 text-sm"><button class="bg-rose-600 text-white rounded-lg px-4 py-2 text-sm">Tolak</button></form></div><?php endif; ?></div><?php if($registration->attendanceVerification): ?><div class="border-t pt-4 mt-4 flex flex-wrap items-center justify-between gap-3"><div><p class="text-sm">Verifikasi: <strong><?php echo e($registration->attendanceVerification->verification_status->value); ?></strong></p><a class="text-blue-700 text-sm underline" href="<?php echo e(route('evidence.download',$registration->attendanceVerification)); ?>">Lihat bukti</a></div><div class="flex gap-2 flex-wrap"><form method="POST" action="<?php echo e(route('verifications.decide',$registration->attendanceVerification)); ?>"><?php echo csrf_field(); ?><input type="hidden" name="action" value="approve"><button class="bg-blue-700 text-white rounded-lg px-4 py-2 text-sm">Verifikasi</button></form><form method="POST" action="<?php echo e(route('verifications.decide',$registration->attendanceVerification)); ?>" class="flex gap-2"><?php echo csrf_field(); ?><input type="hidden" name="action" value="reject"><input name="notes" placeholder="Catatan" class="rounded-lg border-slate-200 text-sm"><button class="bg-rose-600 text-white rounded-lg px-4 py-2 text-sm">Tolak</button></form></div></div><?php endif; ?></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><div class="bg-white p-8 rounded-2xl text-slate-500">Belum ada peserta.</div><?php endif; ?></div><div class="mt-5"><?php echo e($registrations->links()); ?></div></div> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\Sistem Informasi Monitoring Jam Plus dan Soft Skill Mahasiswa\jamplus\resources\views\events\participants.blade.php ENDPATH**/ ?>