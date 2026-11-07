<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'animation' => '',
    'duration' => 'anim-duration-500',
    'delay' => 0,
    'tag' => 'div',
    'controller' => false,
    'useParent' => false,
]));

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

foreach (array_filter(([
    'animation' => '',
    'duration' => 'anim-duration-500',
    'delay' => 0,
    'tag' => 'div',
    'controller' => false,
    'useParent' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $hasAnimation = !empty($animation);
    $delayMs = (int) $delay;
    // Add not-prose to section tags (block roots) to prevent Tailwind Typography from overriding block styles
    $notProseClass = $tag === 'section' ? 'not-prose' : '';
?>

<<?php echo e($tag); ?>

    <?php if($controller): ?>
        
        x-data="{ tallcmsShown: false, tallcmsReducedMotion: window.matchMedia('(prefers-reduced-motion: reduce)').matches }"
        x-intersect:enter.once="tallcmsShown = true"
    <?php elseif($useParent && $hasAnimation): ?>
        
        
        :class="{
            'tallcms-animate animate-<?php echo e($animation); ?> <?php echo e($duration); ?>': typeof tallcmsShown !== 'undefined' && (tallcmsShown || tallcmsReducedMotion),
            'opacity-0': typeof tallcmsShown !== 'undefined' && !tallcmsShown && !tallcmsReducedMotion
        }"
        <?php if($delayMs > 0): ?>
            style="animation-delay: <?php echo e($delayMs); ?>ms"
        <?php endif; ?>
    <?php elseif($hasAnimation): ?>
        
        x-data="{ tallcmsShown: false, tallcmsReducedMotion: window.matchMedia('(prefers-reduced-motion: reduce)').matches }"
        x-intersect:enter.once="tallcmsShown = true"
        :class="tallcmsShown || tallcmsReducedMotion ? 'tallcms-animate animate-<?php echo e($animation); ?> <?php echo e($duration); ?>' : 'opacity-0'"
        <?php if($delayMs > 0): ?>
            style="animation-delay: <?php echo e($delayMs); ?>ms"
        <?php endif; ?>
    <?php endif; ?>
    <?php echo e($attributes->class([$notProseClass])); ?>

>
    <?php echo e($slot); ?>

</<?php echo e($tag); ?>>
<?php /**PATH D:\WSERV\micrandria\vendor\tallcms\cms\resources\views/components/animation-wrapper.blade.php ENDPATH**/ ?>