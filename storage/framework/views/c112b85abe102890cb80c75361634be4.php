<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['item', 'level' => 0]));

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

foreach (array_filter((['item', 'level' => 0]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $hasChildren = !empty($item['children']);
    $isActive = $item['is_active'] ?? false;
    $hasActiveChild = $item['has_active_child'] ?? false;
?>

<li class="<?php echo e($item['css_class'] ?? ''); ?>">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item['type'] === 'header'): ?>
        <li class="menu-title"><?php echo e($item['label']); ?></li>
    <?php elseif($item['type'] === 'separator'): ?>
        <li></li>
    <?php elseif($hasChildren): ?>
        <details>
            <summary class="<?php echo e($isActive || $hasActiveChild ? 'active' : ''); ?>">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item['icon']): ?>
                    <i class="<?php echo e($item['icon']); ?>"></i>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php echo e($item['label']); ?>

            </summary>
            <ul class="bg-base-100 rounded-t-none p-2 min-w-max z-50">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $item['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if (isset($component)) { $__componentOriginalce95f69c1ef890487f9ea684119db87d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce95f69c1ef890487f9ea684119db87d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.menu-item','data' => ['item' => $child,'level' => $level + 1]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('menu-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['item' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($child),'level' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($level + 1)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce95f69c1ef890487f9ea684119db87d)): ?>
<?php $attributes = $__attributesOriginalce95f69c1ef890487f9ea684119db87d; ?>
<?php unset($__attributesOriginalce95f69c1ef890487f9ea684119db87d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce95f69c1ef890487f9ea684119db87d)): ?>
<?php $component = $__componentOriginalce95f69c1ef890487f9ea684119db87d; ?>
<?php unset($__componentOriginalce95f69c1ef890487f9ea684119db87d); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </ul>
        </details>
    <?php elseif($item['url']): ?>
        <a href="<?php echo e($item['url']); ?>"
           class="<?php echo e($isActive ? 'active' : ''); ?>"
           <?php if($isActive): ?> aria-current="page" <?php endif; ?>
           <?php if($item['target'] === '_blank'): ?> target="_blank" rel="noopener" <?php endif; ?>>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item['icon']): ?>
                <i class="<?php echo e($item['icon']); ?>"></i>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php echo e($item['label']); ?>

        </a>
    <?php else: ?>
        <span class="menu-disabled">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item['icon']): ?>
                <i class="<?php echo e($item['icon']); ?>"></i>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php echo e($item['label']); ?>

        </span>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</li>
<?php /**PATH D:\WSERV\micrandria\resources\views/components/menu-item.blade.php ENDPATH**/ ?>