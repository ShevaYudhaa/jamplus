<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['event']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['event']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<a href="<?php echo e(route('browse.show',$event)); ?>" class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300">
 <div class="h-44 relative bg-gradient-to-br from-blue-900 via-blue-700 to-sky-500 overflow-hidden">
  <?php if($event->poster): ?><img class="h-full w-full object-cover" src="<?php echo e(asset('storage/'.$event->poster)); ?>" alt="Poster event"><?php else: ?><div class="flex h-full items-center justify-center text-white/25 text-7xl font-black">J+</div><?php endif; ?>
  <span class="absolute top-4 left-4 bg-white/95 text-blue-800 px-3 py-1 rounded-full text-xs font-bold"><?php echo e($event->category?->name); ?></span>
 </div>
 <div class="p-5 flex flex-col flex-1 gap-3"><div class="text-xs font-bold uppercase tracking-wider text-blue-600"><?php echo e($event->organizerProgram?->name ?? 'Event Kampus'); ?></div><h3 class="text-lg font-extrabold text-slate-900 leading-tight group-hover:text-blue-700 transition"><?php echo e($event->title); ?></h3><p class="text-sm text-slate-500">📅 <?php echo e($event->start_at->translatedFormat('d M Y, H:i')); ?> WIB</p><p class="text-sm text-slate-500">📍 <?php echo e($event->location ?: 'Lokasi belum ditentukan'); ?></p>
 <div class="mt-auto pt-3 flex flex-wrap gap-2"><span class="bg-blue-50 text-blue-800 px-3 py-1.5 rounded-lg text-xs font-bold"><?php if($event->jam_plus_offer): ?> +<?php echo e((float)$event->jam_plus_offer); ?> Jam Plus <?php endif; ?> <?php if($event->soft_skill_points_offer): ?> +<?php echo e((float)$event->soft_skill_points_offer); ?> Soft Skill <?php endif; ?></span></div>
 <div class="border-t border-slate-100 pt-3 text-xs text-slate-500"><?php echo e($event->quota ? max(0,$event->quota-$event->approved_count).' kuota tersisa':'Tanpa batas kuota'); ?> <span class="float-right text-blue-700 font-semibold">Lihat detail →</span></div>
 </div>
</a>
<?php /**PATH C:\xampp\htdocs\Sistem Informasi Monitoring Jam Plus dan Soft Skill Mahasiswa\jamplus\resources\views\components\event-card.blade.php ENDPATH**/ ?>