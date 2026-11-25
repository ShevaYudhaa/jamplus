<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php $__env->slot('header', null, []); ?> <h2 class="text-xl font-bold">Progres Saya</h2> <?php $__env->endSlot(); ?><div class="max-w-5xl mx-auto px-4 py-8"><h1 class="text-3xl font-black text-slate-900 mb-2">Pencapaian Kamu 🏆</h1><p class="text-slate-500 mb-8">Reward dihitung dari kehadiran yang sudah diverifikasi.</p><div class="grid sm:grid-cols-2 gap-6 mb-8"><div class="rounded-3xl bg-blue-800 text-white p-8"><p class="text-blue-200 font-semibold">Total Jam Plus</p><div class="text-5xl font-black mt-2"><?php echo e(number_format((float)$totals->jam,2)); ?></div></div><div class="rounded-3xl bg-slate-900 text-white p-8"><p class="text-slate-300 font-semibold">Poin Soft Skill</p><div class="text-5xl font-black mt-2"><?php echo e(number_format((float)$totals->soft,2)); ?></div></div></div><div class="bg-white border rounded-2xl p-6"><h2 class="text-lg font-black mb-5">Rincian Reward</h2><?php $__empty_1 = true; $__currentLoopData = $rewards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reward): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><div class="flex justify-between border-b py-4 gap-4"><div class="font-semibold"><?php echo e($reward->registration->event->title); ?></div><div class="text-blue-700 text-sm font-bold">+<?php echo e((float)$reward->jam_plus); ?> Jam · +<?php echo e((float)$reward->soft_skill_points); ?> Soft Skill</div></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><p class="text-slate-500">Belum ada reward terverifikasi.</p><?php endif; ?></div><div class="mt-5"><?php echo e($rewards->links()); ?></div></div> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\Sistem Informasi Monitoring Jam Plus dan Soft Skill Mahasiswa\jamplus\resources\views\student\progress.blade.php ENDPATH**/ ?>