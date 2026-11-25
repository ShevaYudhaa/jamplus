<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php $__env->slot('header', null, []); ?> <h2 class="text-xl font-bold">Dashboard Admin</h2> <?php $__env->endSlot(); ?><div class="max-w-7xl mx-auto px-4 py-8"><?php if (isset($component)) { $__componentOriginala37bee3be1b7b9366ae2ff14e78e37db = $component; } ?>
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
<?php endif; ?><div class="rounded-3xl bg-slate-950 text-white p-9 mb-8"><p class="text-sm text-blue-300 font-bold uppercase tracking-widest">Monitoring Program Studi</p><h1 class="text-3xl font-black mt-3">Selamat datang, <?php echo e(auth()->user()->name); ?> 👋</h1><p class="text-slate-300 mt-3">Pantau kegiatan dan pencapaian mahasiswa <?php echo e(auth()->user()->studyProgram->name); ?>.</p></div><div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5"><?php $__currentLoopData = ['events'=>['Event Aktif','📅'],'registrations'=>['Pendaftaran Pending','🕒'],'verifications'=>['Verifikasi Pending','✅'],'students'=>['Total Mahasiswa','🎓']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$meta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div class="bg-white p-6 border rounded-2xl"><div class="text-3xl"><?php echo e($meta[1]); ?></div><div class="text-sm text-slate-500 mt-4"><?php echo e($meta[0]); ?></div><div class="text-4xl font-black text-slate-900 mt-1"><?php echo e($stats[$key]); ?></div></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div><div class="mt-8 flex flex-wrap gap-3"><a class="rounded-xl bg-blue-700 text-white px-5 py-3 font-semibold" href="<?php echo e(route('admin.pending')); ?>">Tinjau Pending</a><a class="rounded-xl border bg-white px-5 py-3 font-semibold" href="<?php echo e(route('events.index')); ?>">Kelola Event</a><a class="rounded-xl border bg-white px-5 py-3 font-semibold" href="<?php echo e(route('admin.students')); ?>">Monitoring Mahasiswa</a></div></div> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\Sistem Informasi Monitoring Jam Plus dan Soft Skill Mahasiswa\jamplus\resources\views\admin\dashboard.blade.php ENDPATH**/ ?>