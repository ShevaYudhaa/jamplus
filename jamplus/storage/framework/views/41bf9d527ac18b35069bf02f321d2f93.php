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
  <?php $__env->slot('header', null, []); ?> <h2 class="text-xl font-bold">Dashboard Super Admin</h2> <?php $__env->endSlot(); ?>
 <div class="max-w-7xl mx-auto px-4 py-8">
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
  <section class="bg-slate-950 text-white rounded-3xl p-8 mb-7"><p class="text-blue-300 uppercase text-xs font-bold tracking-widest">Administrasi Sistem</p><h1 class="text-3xl font-black mt-3">Selamat datang, <?php echo e(auth()->user()->name); ?></h1><p class="text-slate-300 mt-2">Kelola master pengguna seluruh program studi dari satu tempat.</p></section>
  <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-7"><?php $__currentLoopData = ['users'=>'Total Pengguna','students'=>'Mahasiswa','admins'=>'Admin Prodi','inactive'=>'Nonaktif']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div class="bg-white border rounded-2xl p-6"><p class="text-sm text-slate-500"><?php echo e($label); ?></p><p class="text-3xl font-black mt-2"><?php echo e($counts[$key]); ?></p></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div>
  <a href="<?php echo e(route('master.users.index')); ?>" class="inline-block bg-blue-700 text-white rounded-xl px-6 py-3 font-semibold hover:bg-blue-800">Buka Master User</a>
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
<?php /**PATH C:\xampp\htdocs\Sistem Informasi Monitoring Jam Plus dan Soft Skill Mahasiswa\jamplus\resources\views/master/dashboard.blade.php ENDPATH**/ ?>