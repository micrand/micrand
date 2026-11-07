<?php
    $columnsClass = match($columns ?? '3') {
        '1' => 'max-w-2xl mx-auto',
        '2' => 'sm:grid-cols-2 max-w-4xl mx-auto',
        '3' => 'sm:grid-cols-2 lg:grid-cols-3',
        default => 'sm:grid-cols-2 lg:grid-cols-3',
    };

    $styleClasses = $card_style ?? 'card bg-base-200 shadow-lg';
    $isQuoteMarks = str_contains($styleClasses, 'quote-marks');
    $styleClasses = str_replace('quote-marks', 'relative', $styleClasses);
    $isSingleLayout = ($layout ?? 'grid') === 'single';
    $sectionPadding = ($first_section ?? false) ? 'pb-16' : ($padding ?? 'py-16');

    $animationType = $animation_type ?? '';
    $animationDuration = $animation_duration ?? 'anim-duration-500';
    $animationStagger = $animation_stagger ?? false;
    $staggerDelay = (int) ($animation_stagger_delay ?? 100);
?>

<?php if (isset($component)) { $__componentOriginalfa91448da0212bf659eadcbd610ad38e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa91448da0212bf659eadcbd610ad38e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tallcms::components.animation-wrapper','data' => ['tag' => 'section','animation' => $animationType,'controller' => true,'id' => $anchor_id ?? null,'class' => 'testimonials-block '.e($sectionPadding).' '.e($background ?? 'bg-base-100').' '.e($css_classes ?? '').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallcms::animation-wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tag' => 'section','animation' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationType),'controller' => true,'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($anchor_id ?? null),'class' => 'testimonials-block '.e($sectionPadding).' '.e($background ?? 'bg-base-100').' '.e($css_classes ?? '').'']); ?>
    <div class="<?php echo e($contentWidthClass ?? 'max-w-7xl mx-auto'); ?> <?php echo e($contentPadding ?? 'px-4 sm:px-6 lg:px-8'); ?>">
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($heading) || !empty($subheading)): ?>
            <?php if (isset($component)) { $__componentOriginalfa91448da0212bf659eadcbd610ad38e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa91448da0212bf659eadcbd610ad38e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tallcms::components.animation-wrapper','data' => ['animation' => $animationType,'duration' => $animationDuration,'useParent' => true,'class' => ''.e($text_alignment ?? 'text-center').' mb-12 sm:mb-16']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallcms::animation-wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['animation' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationType),'duration' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationDuration),'use-parent' => true,'class' => ''.e($text_alignment ?? 'text-center').' mb-12 sm:mb-16']); ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($heading)): ?>
                    <h2 class="text-3xl sm:text-4xl font-bold tracking-tight text-base-content">
                        <?php echo e($heading); ?>

                    </h2>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($subheading)): ?>
                    <p class="mt-4 text-lg sm:text-xl text-base-content/70 max-w-3xl <?php echo e(($text_alignment ?? 'text-center') === 'text-center' ? 'mx-auto' : ''); ?>">
                        <?php echo e($subheading); ?>

                    </p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($testimonials)): ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isSingleLayout): ?>
                
                <div class="max-w-4xl mx-auto">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $itemDelay = $animationStagger ? ($staggerDelay * ($index + 1)) : 0;
                        ?>
                        <?php if (isset($component)) { $__componentOriginalfa91448da0212bf659eadcbd610ad38e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa91448da0212bf659eadcbd610ad38e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tallcms::components.animation-wrapper','data' => ['animation' => $animationType,'duration' => $animationDuration,'useParent' => true,'delay' => $itemDelay,'class' => ''.e($styleClasses).' '.e(!$loop->last ? 'mb-8' : '').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallcms::animation-wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['animation' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationType),'duration' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationDuration),'use-parent' => true,'delay' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($itemDelay),'class' => ''.e($styleClasses).' '.e(!$loop->last ? 'mb-8' : '').'']); ?>
                            <div class="card-body">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isQuoteMarks): ?>
                                    <div class="absolute top-4 left-6 text-6xl text-primary/20 font-serif leading-none">"</div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($show_rating ?? true) && !empty($testimonial['rating'])): ?>
                                    <div class="rating rating-sm mb-4 <?php echo e($isQuoteMarks ? 'relative z-10' : ''); ?>">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?>
                                            <input
                                                type="radio"
                                                class="mask mask-star-2 bg-warning"
                                                disabled
                                                <?php echo e($i === (int)$testimonial['rating'] ? 'checked' : ''); ?>

                                            />
                                        <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                
                                <blockquote class="text-xl sm:text-2xl leading-relaxed mb-6 text-base-content/80 <?php echo e($isQuoteMarks ? 'relative z-10 pl-8' : ''); ?>">
                                    <?php echo e($testimonial['quote']); ?>

                                </blockquote>

                                
                                <div class="flex items-center gap-4">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($testimonial['author_image'])): ?>
                                        <div class="avatar">
                                            <div class="w-14 rounded-full">
                                                <img
                                                    src="<?php echo e(Storage::disk(cms_media_disk())->url($testimonial['author_image'])); ?>"
                                                    alt="<?php echo e($testimonial['author_name'] ?? ''); ?>"
                                                    loading="lazy"
                                                >
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="avatar placeholder">
                                            <div class="w-14 rounded-full bg-primary/10 text-primary">
                                                <span class="text-xl font-semibold">
                                                    <?php echo e(substr($testimonial['author_name'] ?? 'A', 0, 1)); ?>

                                                </span>
                                            </div>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <div>
                                        <div class="font-semibold text-base-content">
                                            <?php echo e($testimonial['author_name']); ?>

                                        </div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($testimonial['author_title'])): ?>
                                            <div class="text-sm text-base-content/70">
                                                <?php echo e($testimonial['author_title']); ?>

                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($show_company_logo ?? false) && !empty($testimonial['company_logo'])): ?>
                                        <img
                                            src="<?php echo e(Storage::disk(cms_media_disk())->url($testimonial['company_logo'])); ?>"
                                            alt="Company logo"
                                            class="h-8 ml-auto object-contain opacity-60"
                                            loading="lazy"
                                        >
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
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
            <?php else: ?>
                
                <div class="grid gap-6 sm:gap-8 <?php echo e($columnsClass); ?>">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $itemDelay = $animationStagger ? ($staggerDelay * ($index + 1)) : 0;
                        ?>
                        <?php if (isset($component)) { $__componentOriginalfa91448da0212bf659eadcbd610ad38e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa91448da0212bf659eadcbd610ad38e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tallcms::components.animation-wrapper','data' => ['animation' => $animationType,'duration' => $animationDuration,'useParent' => true,'delay' => $itemDelay,'class' => ''.e($styleClasses).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallcms::animation-wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['animation' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationType),'duration' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationDuration),'use-parent' => true,'delay' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($itemDelay),'class' => ''.e($styleClasses).'']); ?>
                            <div class="card-body">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isQuoteMarks): ?>
                                    <div class="absolute top-4 left-6 text-5xl text-primary/20 font-serif leading-none">"</div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($show_rating ?? true) && !empty($testimonial['rating'])): ?>
                                    <div class="rating rating-sm mb-3 <?php echo e($isQuoteMarks ? 'relative z-10' : ''); ?>">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?>
                                            <input
                                                type="radio"
                                                class="mask mask-star-2 bg-warning"
                                                disabled
                                                <?php echo e($i === (int)$testimonial['rating'] ? 'checked' : ''); ?>

                                            />
                                        <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                
                                <blockquote class="text-base leading-relaxed mb-6 text-base-content/80 <?php echo e($isQuoteMarks ? 'relative z-10 pl-6' : ''); ?>">
                                    <?php echo e($testimonial['quote']); ?>

                                </blockquote>

                                
                                <div class="flex items-center gap-3 mt-auto">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($testimonial['author_image'])): ?>
                                        <div class="avatar">
                                            <div class="w-10 rounded-full">
                                                <img
                                                    src="<?php echo e(Storage::disk(cms_media_disk())->url($testimonial['author_image'])); ?>"
                                                    alt="<?php echo e($testimonial['author_name'] ?? ''); ?>"
                                                    loading="lazy"
                                                >
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="avatar placeholder">
                                            <div class="w-10 rounded-full bg-primary/10 text-primary">
                                                <span class="text-sm font-semibold">
                                                    <?php echo e(substr($testimonial['author_name'] ?? 'A', 0, 1)); ?>

                                                </span>
                                            </div>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <div class="min-w-0 flex-1">
                                        <div class="font-semibold text-sm truncate text-base-content">
                                            <?php echo e($testimonial['author_name']); ?>

                                        </div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($testimonial['author_title'])): ?>
                                            <div class="text-xs truncate text-base-content/70">
                                                <?php echo e($testimonial['author_title']); ?>

                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>

                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($show_company_logo ?? false) && !empty($testimonial['company_logo'])): ?>
                                    <div class="mt-4 pt-4 border-t border-base-300">
                                        <img
                                            src="<?php echo e(Storage::disk(cms_media_disk())->url($testimonial['company_logo'])); ?>"
                                            alt="Company logo"
                                            class="h-6 object-contain opacity-50"
                                            loading="lazy"
                                        >
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
<?php /**PATH D:\WSERV\micrandria\vendor\tallcms\cms\resources\views/cms/blocks/testimonials.blade.php ENDPATH**/ ?>