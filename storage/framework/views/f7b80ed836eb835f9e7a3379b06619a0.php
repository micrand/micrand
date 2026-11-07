<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['location', 'style' => 'horizontal']));

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

foreach (array_filter((['location', 'style' => 'horizontal']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $menuData = menu($location);

    if (!$menuData) {
        return;
    }

    // Themes can override menu styles by creating: themes/{slug}/resources/views/components/menu/{$style}.blade.php
    $themeView = "components.menu.{$style}";

    // Fallback to horizontal if style doesn't exist
    if (!view()->exists($themeView)) {
        $themeView = "components.menu.horizontal";
    }
?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($menuData): ?>
    <nav <?php echo e($attributes); ?> data-menu-location="<?php echo e($location); ?>">
        <?php echo $__env->make($themeView, ['items' => $menuData, 'location' => $location], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </nav>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?><?php /**PATH D:\WSERV\micrandria\resources\views/components/menu.blade.php ENDPATH**/ ?>