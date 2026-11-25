<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php $__env->slot('header', null, []); ?> <h2 class="text-xl font-bold">Kelola Event</h2> <?php $__env->endSlot(); ?><div class="max-w-7xl mx-auto px-4 py-8"><?php if (isset($component)) { $__componentOriginala37bee3be1b7b9366ae2ff14e78e37db = $component; } ?>
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
<?php endif; ?><div class="flex justify-between flex-wrap items-center gap-4 mb-8"><div><h1 class="text-3xl font-black">Event yang Dikelola</h1><p class="text-sm text-slate-500 mt-1">Buat acara dan kelola peserta serta verifikasi.</p></div><?php if($canCreate): ?><a class="bg-blue-700 text-white rounded-xl px-5 py-3 font-bold" href="<?php echo e(route('events.create')); ?>">+ Buat Event</a><?php endif; ?></div><div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5"><?php $__empty_1 = true; $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><div class="rounded-2xl bg-white border border-slate-200 p-6"><span class="text-xs font-bold uppercase text-blue-600"><?php echo e($event->category->name); ?> · <?php echo e($event->status->value); ?></span><h2 class="font-extrabold text-lg mt-2"><?php echo e($event->title); ?></h2><p class="text-sm text-slate-500 mt-2"><?php echo e($event->start_at->translatedFormat('d M Y H:i')); ?> · <?php echo e($event->approved_count); ?> peserta approved</p><div class="flex flex-wrap gap-3 mt-6 text-sm font-bold"><a class="text-blue-700" href="<?php echo e(route('events.edit',$event)); ?>">Edit</a><a class="text-blue-700" href="<?php echo e(route('events.participants',$event)); ?>">Peserta</a><form method="POST" action="<?php echo e(route('events.cancel',$event)); ?>" onsubmit="return confirm('Batalkan event ini?')"><?php echo csrf_field(); ?><button class="text-rose-600">Batalkan</button></form></div></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><div class="text-slate-500 bg-white p-8 rounded-2xl">Belum ada event.</div><?php endif; ?></div><div class="mt-6"><?php echo e($events->links()); ?></div></div> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\Sistem Informasi Monitoring Jam Plus dan Soft Skill Mahasiswa\jamplus\resources\views/events/manage.blade.php ENDPATH**/ ?>