<?php
    $columnsClass = match($columns ?? '4') {
        '2' => 'sm:grid-cols-2 max-w-3xl mx-auto',
        '3' => 'sm:grid-cols-3 max-w-5xl mx-auto',
        '4' => 'sm:grid-cols-2 lg:grid-cols-4',
        default => 'sm:grid-cols-2 lg:grid-cols-4',
    };

    $sectionPadding = ($first_section ?? false) ? 'pb-16' : ($padding ?? 'py-16');
    $shouldAnimate = $animate ?? false;

    $animationType = $animation_type ?? '';
    $animationDuration = $animation_duration ?? 'anim-duration-500';
    $animationStagger = $animation_stagger ?? false;
    $staggerDelay = (int) ($animation_stagger_delay ?? 100);

    // StatsBlock requires merging animation state with count-up animation x-data
    $hasEntranceAnimation = !empty($animationType);

    // Build anchor ID attribute (avoid @if inside tag to prevent Blade comment injection)
    $anchorIdAttr = !empty($anchor_id) ? 'id="' . e($anchor_id) . '"' : '';

    // Build x-intersect attribute (avoid @if inside attribute value)
    $animateCode = $shouldAnimate ? " \$el.querySelectorAll('[data-stat-value]').forEach(el => animateValue(el, el.dataset.statValue))" : '';
    $xIntersect = 'tallcmsShown = true;' . $animateCode;

    // Build :class attribute for entrance animation (avoid @if inside tag)
    $entranceClassAttr = $hasEntranceAnimation
        ? ':class="tallcmsShown || tallcmsReducedMotion ? \'tallcms-animate animate-' . e($animationType) . ' ' . e($animationDuration) . '\' : \'opacity-0\'"'
        : '';
?>

<section
    <?php echo $anchorIdAttr; ?>

    class="stats-block <?php echo e($sectionPadding); ?> <?php echo e($background ?? 'bg-base-100'); ?> <?php echo e($css_classes ?? ''); ?>"
    x-data="{
        tallcmsShown: false,
        tallcmsReducedMotion: window.matchMedia('(prefers-reduced-motion: reduce)').matches,
        animateValue(el, target, duration = 2000) {
            const isPureInteger = /^\d+$/.test(target);
            if (this.tallcmsReducedMotion || !isPureInteger) {
                el.textContent = target;
                return;
            }
            const numericTarget = parseInt(target, 10);
            let startTime = null;
            const step = (timestamp) => {
                if (!startTime) startTime = timestamp;
                const progress = Math.min((timestamp - startTime) / duration, 1);
                const easeOutQuart = 1 - Math.pow(1 - progress, 4);
                const current = Math.floor(easeOutQuart * numericTarget);
                el.textContent = current.toLocaleString();
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                } else {
                    el.textContent = numericTarget.toLocaleString();
                }
            };
            window.requestAnimationFrame(step);
        }
    }"
    x-intersect:enter.once="<?php echo e($xIntersect); ?>"
    <?php echo $entranceClassAttr; ?>

>
    <div class="<?php echo e($contentWidthClass ?? 'max-w-7xl mx-auto'); ?> <?php echo e($contentPadding ?? 'px-4 sm:px-6 lg:px-8'); ?>">
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($heading)): ?>
            <?php if (isset($component)) { $__componentOriginalfa91448da0212bf659eadcbd610ad38e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa91448da0212bf659eadcbd610ad38e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tallcms::components.animation-wrapper','data' => ['animation' => $animationType,'duration' => $animationDuration,'useParent' => true,'class' => ''.e($text_alignment ?? 'text-center').' mb-12']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallcms::animation-wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['animation' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationType),'duration' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationDuration),'use-parent' => true,'class' => ''.e($text_alignment ?? 'text-center').' mb-12']); ?>
                <h2 class="text-3xl sm:text-4xl font-bold tracking-tight text-base-content">
                    <?php echo e($heading); ?>

                </h2>
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
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($stats)): ?>
            <div class="stats stats-vertical lg:stats-horizontal shadow w-full <?php echo e($columnsClass); ?> grid">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $itemDelay = $animationStagger ? ($staggerDelay * ($index + 1)) : 0;
                    ?>
                    <?php if (isset($component)) { $__componentOriginalfa91448da0212bf659eadcbd610ad38e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa91448da0212bf659eadcbd610ad38e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tallcms::components.animation-wrapper','data' => ['animation' => $animationType,'duration' => $animationDuration,'useParent' => true,'delay' => $itemDelay,'class' => ''.e($stat_style ?? 'stat').' '.e($text_alignment ?? 'text-center').' place-items-center']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallcms::animation-wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['animation' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationType),'duration' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationDuration),'use-parent' => true,'delay' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($itemDelay),'class' => ''.e($stat_style ?? 'stat').' '.e($text_alignment ?? 'text-center').' place-items-center']); ?>
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($stat['icon'])): ?>
                            <div class="stat-figure text-primary">
                                <?php
                                    $iconName = str_replace(['heroicon-o-', 'heroicon-s-', 'heroicon-m-'], '', $stat['icon']);
                                    $iconStyle = str_starts_with($stat['icon'], 'heroicon-s-') ? 's' : 'o';
                                ?>
                                <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => 'heroicon-' . $iconStyle . '-' . $iconName] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-8 h-8']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $attributes = $__attributesOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $component = $__componentOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__componentOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        
                        <div class="stat-value text-primary">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($stat['prefix'])): ?>
                                <span><?php echo e($stat['prefix']); ?></span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($shouldAnimate): ?>
                                <span data-stat-value="<?php echo e($stat['value']); ?>">0</span>
                            <?php else: ?>
                                <span><?php echo e($stat['value']); ?></span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($stat['suffix'])): ?>
                                <span><?php echo e($stat['suffix']); ?></span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        
                        <div class="stat-title text-base-content/70">
                            <?php echo e($stat['label']); ?>

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
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</section>
<?php /**PATH D:\WSERV\micrandria\vendor\tallcms\cms\resources\views/cms/blocks/stats.blade.php ENDPATH**/ ?>