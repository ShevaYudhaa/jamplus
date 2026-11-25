<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php $__env->slot('header', null, []); ?> <h2 class="font-bold text-xl text-slate-900">Jelajahi Event Kampus</h2> <?php $__env->endSlot(); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
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
 <div class="rounded-3xl bg-gradient-to-r from-slate-950 to-blue-800 text-white p-8 md:p-12 mb-8 relative overflow-hidden"><div class="relative z-10 max-w-2xl"><span class="text-blue-200 text-xs font-bold tracking-widest uppercase">Temukan peluang, kumpulkan pengalaman</span><h1 class="text-3xl md:text-5xl font-black tracking-tight mt-3 mb-4 leading-tight">Ikuti event seru.<br><span class="text-sky-300">Tambah Jam Plus-mu.</span></h1><p class="text-blue-100 text-sm md:text-base">Jelajahi seminar, workshop, lomba, dan kegiatan kampus. Kumpulkan Jam Plus serta poin Soft Skill dari setiap kontribusimu.</p></div><div class="hidden md:block absolute -right-10 -top-20 rounded-full h-80 w-80 border-[55px] border-white/5"></div></div>
 <form class="grid md:grid-cols-4 gap-3 mb-8 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm" action="<?php echo e(route('browse')); ?>" method="GET"><input class="rounded-xl border-slate-200 md:col-span-2" name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari event, seminar, workshop..."><select name="category" class="rounded-xl border-slate-200"><option value="">Semua kategori</option><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($category->id); ?>" <?php if(request('category')==$category->id): echo 'selected'; endif; ?>><?php echo e($category->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select><select name="reward" class="rounded-xl border-slate-200"><option value="">Semua reward</option><option value="jam_plus" <?php if(request('reward')==='jam_plus'): echo 'selected'; endif; ?>>Jam Plus</option><option value="soft_skill" <?php if(request('reward')==='soft_skill'): echo 'selected'; endif; ?>>Soft Skill</option><option value="both" <?php if(request('reward')==='both'): echo 'selected'; endif; ?>>Keduanya</option></select><button class="md:col-span-4 bg-blue-700 text-white py-3 rounded-xl font-bold hover:bg-blue-800">Cari Event</button></form>
 <div class="flex justify-between items-end mb-5"><div><h2 class="text-2xl font-extrabold text-slate-900">Event untuk Kamu</h2><p class="text-slate-500 text-sm mt-1"><?php echo e($events->total()); ?> event tersedia</p></div></div>
 <?php if($events->isEmpty()): ?><div class="bg-white border border-dashed border-slate-300 rounded-2xl text-center p-16 text-slate-500">Belum ada event yang sesuai pencarian.</div><?php else: ?><div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6"><?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if (isset($component)) { $__componentOriginal07bdbe031a4c57e4cd3488994f94e999 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal07bdbe031a4c57e4cd3488994f94e999 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.event-card','data' => ['event' => $event]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('event-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['event' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($event)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal07bdbe031a4c57e4cd3488994f94e999)): ?>
<?php $attributes = $__attributesOriginal07bdbe031a4c57e4cd3488994f94e999; ?>
<?php unset($__attributesOriginal07bdbe031a4c57e4cd3488994f94e999); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal07bdbe031a4c57e4cd3488994f94e999)): ?>
<?php $component = $__componentOriginal07bdbe031a4c57e4cd3488994f94e999; ?>
<?php unset($__componentOriginal07bdbe031a4c57e4cd3488994f94e999); ?>
<?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div><div class="mt-8"><?php echo e($events->links()); ?></div><?php endif; ?>
</div> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\Sistem Informasi Monitoring Jam Plus dan Soft Skill Mahasiswa\jamplus\resources\views\student\home.blade.php ENDPATH**/ ?>