<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php $__env->slot('header', null, []); ?> <h2 class="font-bold text-xl">Detail Event</h2> <?php $__env->endSlot(); ?><div class="max-w-5xl mx-auto px-4 py-8"><?php if (isset($component)) { $__componentOriginala37bee3be1b7b9366ae2ff14e78e37db = $component; } ?>
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
<?php endif; ?><a class="text-sm text-blue-700 font-semibold" href="<?php echo e(route('browse')); ?>">← Kembali ke jelajah</a><div class="bg-white rounded-3xl overflow-hidden border border-slate-200 shadow-sm mt-5"><div class="bg-gradient-to-r from-slate-900 to-blue-800 h-60"><?php if($event->poster): ?><img src="<?php echo e(asset('storage/'.$event->poster)); ?>" alt="Poster event" class="w-full h-full object-cover"><?php endif; ?></div><div class="p-6 md:p-10"><span class="px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-sm font-bold"><?php echo e($event->category->name); ?></span><h1 class="text-3xl font-black text-slate-900 mt-4"><?php echo e($event->title); ?></h1><p class="text-slate-500 mt-2">Diselenggarakan oleh <?php echo e($event->organizerProgram?->name); ?></p><div class="grid sm:grid-cols-3 gap-5 my-8 text-sm"><div class="p-4 bg-slate-50 rounded-xl"><strong class="block mb-2">📆 Waktu acara</strong><?php echo e($event->start_at->translatedFormat('d M Y H:i')); ?> WIB<br>hingga <?php echo e($event->end_at->translatedFormat('d M Y H:i')); ?> WIB</div><div class="p-4 bg-slate-50 rounded-xl"><strong class="block mb-2">📍 Lokasi</strong><?php echo e($event->location?:'Belum ditentukan'); ?></div><div class="p-4 bg-blue-50 rounded-xl"><strong class="block mb-2">🏅 Reward</strong><?php if($event->jam_plus_offer): ?> <?php echo e((float)$event->jam_plus_offer); ?> Jam Plus <?php endif; ?> <?php if($event->soft_skill_points_offer): ?> <?php echo e((float)$event->soft_skill_points_offer); ?> poin Soft Skill <?php endif; ?></div></div><h3 class="font-extrabold text-xl mb-3">Tentang acara</h3><p class="whitespace-pre-line text-slate-600 leading-7"><?php echo e($event->description ?: 'Belum ada deskripsi acara.'); ?></p><div class="mt-8 border-t pt-6 flex flex-wrap items-center justify-between gap-4"><p class="text-sm text-slate-500"><?php echo e($event->quota ? max(0,$event->quota-$approved).' tempat tersisa':'Kuota tidak dibatasi'); ?></p><?php if(auth()->user()->role->value==='mahasiswa'): ?><?php if(!$registration): ?><form method="POST" action="<?php echo e(route('register.event',$event)); ?>"><?php echo csrf_field(); ?><button class="bg-blue-700 hover:bg-blue-800 rounded-xl px-8 py-3 font-bold text-white">Daftar Event</button></form><?php else: ?><div class="flex items-center gap-4"><span class="text-sm font-bold">Status: <?php echo e($registration->status->value); ?></span><?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cancel',$registration)): ?><form method="POST" action="<?php echo e(route('register.cancel',$registration)); ?>"><?php echo csrf_field(); ?><button class="px-5 py-3 border rounded-xl text-rose-600">Batalkan</button></form><?php endif; ?></div><?php endif; ?>@endif</div></div></div></div> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\Sistem Informasi Monitoring Jam Plus dan Soft Skill Mahasiswa\jamplus\resources\views\student\detail.blade.php ENDPATH**/ ?>