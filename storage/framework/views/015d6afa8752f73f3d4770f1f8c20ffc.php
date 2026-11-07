<?php
    $isGrid = ($layout ?? 'grid') === 'grid';

    $columnsClass = match($columns ?? '5') {
        '2' => 'grid-cols-1 sm:grid-cols-2',
        '3' => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3',
        '4' => 'grid-cols-2 sm:grid-cols-4',
        '5' => 'grid-cols-2 sm:grid-cols-3 lg:grid-cols-5',
        '6' => 'grid-cols-2 sm:grid-cols-3 lg:grid-cols-6',
        default => 'grid-cols-2 sm:grid-cols-3 lg:grid-cols-5',
    };

    $sizeClasses = match($size ?? 'medium') {
        'small' => 'h-8 max-w-[100px]',
        'medium' => 'h-10 max-w-[140px]',
        'large' => 'h-14 max-w-[180px]',
        default => 'h-10 max-w-[140px]',
    };

    $grayscaleClass = ($grayscale ?? true) ? 'grayscale opacity-60' : '';
    $hoverColorClass = (($grayscale ?? true) && ($hover_color ?? true)) ? 'hover:grayscale-0 hover:opacity-100' : '';

    $sectionPadding = ($first_section ?? false) ? 'pb-16' : ($padding ?? 'py-16');

    $animationType = $animation_type ?? '';
    $animationDuration = $animation_duration ?? 'anim-duration-700';
?>

<?php if (isset($component)) { $__componentOriginalfa91448da0212bf659eadcbd610ad38e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa91448da0212bf659eadcbd610ad38e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tallcms::components.animation-wrapper','data' => ['tag' => 'section','animation' => $animationType,'duration' => $animationDuration,'id' => $anchor_id ?? null,'class' => 'logos-block '.e($sectionPadding).' '.e($background ?? 'bg-base-100').' '.e($css_classes ?? '').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallcms::animation-wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tag' => 'section','animation' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationType),'duration' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationDuration),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($anchor_id ?? null),'class' => 'logos-block '.e($sectionPadding).' '.e($background ?? 'bg-base-100').' '.e($css_classes ?? '').'']); ?>
    <div class="<?php echo e($contentWidthClass ?? 'max-w-7xl mx-auto'); ?> <?php echo e($contentPadding ?? 'px-4 sm:px-6 lg:px-8'); ?>">
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($heading)): ?>
            <div class="text-center mb-10">
                <p class="text-sm sm:text-base font-medium uppercase tracking-wider text-base-content/70">
                    <?php echo e($heading); ?>

                </p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($logos)): ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isGrid): ?>
                
                <div class="grid <?php echo e($columnsClass); ?> gap-8 items-center justify-items-center">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $logos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $logo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($logo['image'])): ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($logo['url'])): ?>
                                <a
                                    href="<?php echo e($logo['url']); ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="logo-item flex items-center justify-center transition-all duration-300 <?php echo e($grayscaleClass); ?> <?php echo e($hoverColorClass); ?>"
                                >
                                    <img
                                        src="<?php echo e(Storage::disk(cms_media_disk())->url($logo['image'])); ?>"
                                        alt="<?php echo e($logo['alt'] ?? ''); ?>"
                                        class="object-contain <?php echo e($sizeClasses); ?>"
                                    >
                                </a>
                            <?php else: ?>
                                <div class="logo-item flex items-center justify-center transition-all duration-300 <?php echo e($grayscaleClass); ?> <?php echo e($hoverColorClass); ?>">
                                    <img
                                        src="<?php echo e(Storage::disk(cms_media_disk())->url($logo['image'])); ?>"
                                        alt="<?php echo e($logo['alt'] ?? ''); ?>"
                                        class="object-contain <?php echo e($sizeClasses); ?>"
                                    >
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php else: ?>
                            
                            <div class="logo-placeholder flex items-center justify-center <?php echo e($sizeClasses); ?> bg-base-200 rounded">
                                <span class="text-xs text-base-content/50"><?php echo e($logo['alt'] ?? 'Logo'); ?></span>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php else: ?>
                
                <div class="flex flex-wrap items-center justify-center gap-8 sm:gap-12">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $logos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $logo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($logo['image'])): ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($logo['url'])): ?>
                                <a
                                    href="<?php echo e($logo['url']); ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="logo-item flex items-center justify-center transition-all duration-300 <?php echo e($grayscaleClass); ?> <?php echo e($hoverColorClass); ?>"
                                >
                                    <img
                                        src="<?php echo e(Storage::disk(cms_media_disk())->url($logo['image'])); ?>"
                                        alt="<?php echo e($logo['alt'] ?? ''); ?>"
                                        class="object-contain <?php echo e($sizeClasses); ?>"
                                    >
                                </a>
                            <?php else: ?>
                                <div class="logo-item flex items-center justify-center transition-all duration-300 <?php echo e($grayscaleClass); ?> <?php echo e($hoverColorClass); ?>">
                                    <img
                                        src="<?php echo e(Storage::disk(cms_media_disk())->url($logo['image'])); ?>"
                                        alt="<?php echo e($logo['alt'] ?? ''); ?>"
                                        class="object-contain <?php echo e($sizeClasses); ?>"
                                    >
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php else: ?>
                            
                            <div class="logo-placeholder flex items-center justify-center <?php echo e($sizeClasses); ?> bg-base-200 rounded px-4">
                                <span class="text-xs text-base-content/50"><?php echo e($logo['alt'] ?? 'Logo'); ?></span>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
<?php /**PATH D:\WSERV\micrandria\vendor\tallcms\cms\resources\views/cms/blocks/logos.blade.php ENDPATH**/ ?>