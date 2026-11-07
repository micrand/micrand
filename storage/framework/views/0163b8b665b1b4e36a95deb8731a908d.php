<?php
    $hasSecondaryButton = !empty($secondary_button_text) && !empty($secondary_button_url) && $secondary_button_url !== '#';
    $hasButton = !empty($button_text) && !empty($button_url) && $button_url !== '#';

    // Alignment helper classes
    $alignmentClasses = match($text_alignment ?? 'text-center') {
        'text-left' => 'text-left items-start',
        'text-right' => 'text-right items-end',
        default => 'text-center items-center',
    };

    $buttonAlignClass = match($text_alignment ?? 'text-center') {
        'text-left' => 'justify-start',
        'text-right' => 'justify-end',
        default => 'justify-center',
    };

    $animationType = $animation_type ?? '';
    $animationDuration = $animation_duration ?? 'anim-duration-500';
?>

<?php if (isset($component)) { $__componentOriginalfa91448da0212bf659eadcbd610ad38e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa91448da0212bf659eadcbd610ad38e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tallcms::components.animation-wrapper','data' => ['tag' => 'section','animation' => $animationType,'duration' => $animationDuration,'id' => $anchor_id ?? null,'class' => ''.e($padding ?? 'py-16').' '.e($background ?? 'bg-base-200').' '.e($css_classes ?? '').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallcms::animation-wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tag' => 'section','animation' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationType),'duration' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationDuration),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($anchor_id ?? null),'class' => ''.e($padding ?? 'py-16').' '.e($background ?? 'bg-base-200').' '.e($css_classes ?? '').'']); ?>
    <div class="<?php echo e($contentWidthClass ?? 'max-w-6xl mx-auto'); ?> <?php echo e($contentPadding ?? 'px-4 sm:px-6 lg:px-8'); ?> flex flex-col <?php echo e($alignmentClasses); ?>">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($title ?? null): ?>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight text-base-content mb-6">
                <?php echo e($title); ?>

            </h2>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($description ?? null): ?>
            <p class="text-lg leading-relaxed text-base-content/80 <?php echo e(($text_alignment ?? 'text-center') === 'text-center' ? 'max-w-2xl' : ''); ?> mb-10">
                <?php echo e($description); ?>

            </p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasButton || $hasSecondaryButton): ?>
            <div class="flex flex-wrap gap-6 <?php echo e($buttonAlignClass); ?>">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasButton): ?>
                    <div class="flex flex-col items-center gap-2">
                        <a href="<?php echo e(e($button_url)); ?>" class="<?php echo e($button_classes ?? 'btn btn-primary'); ?> gap-2">
                            <?php echo e($button_text); ?>

                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($button_microcopy ?? null): ?>
                            <span class="text-sm text-base-content/60"><?php echo e($button_microcopy); ?></span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasSecondaryButton): ?>
                    <div class="flex flex-col items-center gap-2">
                        <a href="<?php echo e(e($secondary_button_url)); ?>" class="<?php echo e($secondary_button_classes ?? 'btn btn-ghost'); ?>">
                            <?php echo e($secondary_button_text); ?>

                        </a>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($secondary_button_microcopy ?? null): ?>
                            <span class="text-sm text-base-content/60"><?php echo e($secondary_button_microcopy); ?></span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfa91448da0212bf659eadcbd610ad38e)): ?>
<?php $attributes = $__attributesOriginalfa91448da0212bf659eadcbd610ad38e; ?>
<?php unset($__attributesOriginalfa91448da0212bf659eadcbd610ad38e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfa91448da0212bf659eadcbd610ad38e)): ?>
<?php $component = $__componentOriginalfa91448da0212bf659eadcbd610ad38e; ?>
<?php unset($__componentOriginalfa91448da0212bf659eadcbd610ad38e); ?>
<?php endif; ?>
<?php /**PATH D:\WSERV\micrandria\vendor\tallcms\cms\resources\views/cms/blocks/call-to-action.blade.php ENDPATH**/ ?>