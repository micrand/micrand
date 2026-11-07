<?php
    use TallCms\Cms\Services\BlockLinkResolver;

    $isPreview = $isPreview ?? false;

    // Preserve RichEditor data-color → class transform
    $processedHeading = preg_replace('/data-color="([^"]+)"/', 'class="$1"', $heading ?? '');
    $processedSubheading = preg_replace('/data-color="([^"]+)"/', 'class="$1"', $subheading ?? '');

    // Layout classes for hero-content
    $layoutClasses = match($layout ?? 'centered') {
        'figure-left' => 'flex-col lg:flex-row gap-8 lg:gap-12',
        'figure-right' => 'flex-col lg:flex-row-reverse gap-8 lg:gap-12',
        'with-form' => 'flex-col lg:flex-row gap-8 lg:gap-12',
        default => '',  // centered uses text-center on content div
    };

    // Button alignment based on text_alignment (preserved for all layouts)
    $buttonAlignClass = match($text_alignment ?? 'text-center') {
        'text-left' => 'justify-start',
        'text-right' => 'justify-end',
        default => 'justify-center',
    };

    $hasBackgroundImage = ($background_image ?? null) && Storage::disk(cms_media_disk())->exists($background_image);
    $hasOverlay = $hasBackgroundImage;

    // Overlay opacity: PHP already converts 0-100 to 0-1, receive as decimal
    $overlayOpacity = $overlay_opacity ?? 0.4;

    // Figure image existence check
    $hasFigureImage = ($figure_image ?? null) && Storage::disk(cms_media_disk())->exists($figure_image);

    // Determine if we're on a dark background (overlay or dark bg color)
    $isDarkBackground = $hasOverlay || in_array($background_color ?? '', [
        'bg-primary', 'bg-secondary', 'bg-accent', 'bg-neutral',
        'bg-gradient-to-br from-primary to-secondary'
    ]);

    // Text color class - applied to text content column ONLY (not hero-content, not form card)
    $textColorClass = $isDarkBackground ? 'text-neutral-content' : 'text-base-content';

    // Microcopy color class
    $microcopyColorClass = $isDarkBackground ? 'text-white/70' : 'text-base-content/70';

    // For light backgrounds, explicitly use standard button variants
    if (!$isDarkBackground) {
        $buttonSize = $button_size ?? 'btn-lg';
        $button_classes = "btn btn-primary {$buttonSize}";
        $secondary_button_classes = "btn btn-ghost {$buttonSize}";
    }

    // Section classes - keep -mt-20 for non-preview (tucks under nav)
    $sectionClasses = "hero {$height} " . ($isPreview ? '' : '-mt-20') . " relative overflow-hidden " . ($css_classes ?? '');

    // Animation config
    $animationType = $animation_type ?? '';
    $animationDuration = $animation_duration ?? 'anim-duration-700';
?>

<?php if (isset($component)) { $__componentOriginalfa91448da0212bf659eadcbd610ad38e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa91448da0212bf659eadcbd610ad38e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tallcms::components.animation-wrapper','data' => ['tag' => 'section','animation' => $animationType,'controller' => true,'id' => $anchor_id ?? null,'class' => ''.e(trim($sectionClasses)).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallcms::animation-wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tag' => 'section','animation' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationType),'controller' => true,'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($anchor_id ?? null),'class' => ''.e(trim($sectionClasses)).'']); ?>
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasBackgroundImage): ?>
        <div class="absolute inset-0 z-0"
             style="background-image: url('<?php echo e(Storage::disk(cms_media_disk())->url($background_image)); ?>');
                    background-size: cover; background-position: center;
                    <?php if($parallax_effect ?? true): ?> background-attachment: fixed; <?php endif; ?>">
            <div class="absolute inset-0" style="background-color: rgba(0, 0, 0, <?php echo e($overlayOpacity); ?>);"></div>
        </div>
    <?php else: ?>
        <div class="absolute inset-0 z-0 <?php echo e($background_color ?? 'bg-gradient-to-br from-primary to-secondary'); ?>"></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="hero-content <?php echo e($layoutClasses); ?> <?php echo e(($layout ?? 'centered') === 'centered' ? ($text_alignment ?? 'text-center') : ''); ?> w-full px-4 sm:px-6 lg:px-8 py-24 sm:py-32 lg:py-40 relative z-10">

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($layout ?? 'centered', ['figure-left', 'figure-right']) && $hasFigureImage): ?>
            <?php if (isset($component)) { $__componentOriginalfa91448da0212bf659eadcbd610ad38e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa91448da0212bf659eadcbd610ad38e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tallcms::components.animation-wrapper','data' => ['animation' => $animationType,'duration' => $animationDuration,'useParent' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallcms::animation-wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['animation' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationType),'duration' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationDuration),'use-parent' => true]); ?>
                <img src="<?php echo e(Storage::disk(cms_media_disk())->url($figure_image)); ?>"
                     alt="<?php echo e($figure_alt ?? ''); ?>"
                     class="max-w-sm <?php echo e(($figure_rounded ?? true) ? 'rounded-lg' : ''); ?> <?php echo e(($figure_shadow ?? true) ? 'shadow-2xl' : ''); ?>" />
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

        
        <?php if (isset($component)) { $__componentOriginalfa91448da0212bf659eadcbd610ad38e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa91448da0212bf659eadcbd610ad38e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tallcms::components.animation-wrapper','data' => ['animation' => $animationType,'duration' => $animationDuration,'useParent' => true,'class' => ''.e($textColorClass).' '.e(($layout ?? 'centered') === 'centered' ? 'max-w-5xl mx-auto' : 'flex-1').' '.e(($layout ?? 'centered') !== 'centered' ? ($text_alignment ?? 'text-left') : '').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallcms::animation-wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['animation' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationType),'duration' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationDuration),'use-parent' => true,'class' => ''.e($textColorClass).' '.e(($layout ?? 'centered') === 'centered' ? 'max-w-5xl mx-auto' : 'flex-1').' '.e(($layout ?? 'centered') !== 'centered' ? ($text_alignment ?? 'text-left') : '').'']); ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($heading ?? null): ?>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-bold leading-tight mb-6" style="text-shadow: 0 4px 8px rgba(0,0,0,0.25)">
                    <?php echo $processedHeading; ?>

                </h1>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($subheading ?? null): ?>
                <div class="text-lg sm:text-xl lg:text-2xl leading-relaxed mb-10 opacity-85 max-w-3xl <?php echo e(($layout ?? 'centered') === 'centered' ? 'mx-auto' : ''); ?>">
                    <?php echo $processedSubheading; ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($layout ?? 'centered') !== 'with-form' && BlockLinkResolver::shouldRenderButton(get_defined_vars())): ?>
                <div class="flex flex-col sm:flex-row gap-4 <?php echo e($buttonAlignClass); ?>">
                    <div class="flex flex-col items-center gap-2">
                        <a href="<?php echo e(e($button_url)); ?>" class="<?php echo e($button_classes); ?>">
                            <?php echo e($button_text); ?>

                        </a>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($button_microcopy ?? null): ?>
                            <span class="text-sm <?php echo e($microcopyColorClass); ?>"><?php echo e($button_microcopy); ?></span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(BlockLinkResolver::shouldRenderButton(get_defined_vars(), 'secondary_button')): ?>
                        <div class="flex flex-col items-center gap-2">
                            <a href="<?php echo e(e($secondary_button_url)); ?>" class="<?php echo e($secondary_button_classes); ?>">
                                <?php echo e($secondary_button_text); ?>

                            </a>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($secondary_button_microcopy ?? null): ?>
                                <span class="text-sm <?php echo e($microcopyColorClass); ?>"><?php echo e($secondary_button_microcopy); ?></span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
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

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($layout ?? 'centered') === 'with-form'): ?>
            <?php
                // Normalize form fields - use ContactFormBlock defaults if empty
                // The $form_fields should already have defaults from HeroBlock, but double-check here
                $normalizedFields = (isset($form_fields) && is_array($form_fields) && count($form_fields) > 0)
                    ? array_values($form_fields)
                    : \TallCms\Cms\Filament\Blocks\ContactFormBlock::getDefaultFields();
                $formId = 'hero-contact-form-' . uniqid();
                $formButtonStyle = $form_button_style ?? 'btn-primary';
                $formSubmitText = $form_submit_text ?? 'Get Started';
            ?>
            
            <?php if (isset($component)) { $__componentOriginalfa91448da0212bf659eadcbd610ad38e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa91448da0212bf659eadcbd610ad38e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tallcms::components.animation-wrapper','data' => ['animation' => $animationType,'duration' => $animationDuration,'useParent' => true,'class' => 'card '.e($form_card_style ?? 'bg-base-100 shadow-2xl').' w-full max-w-md shrink-0 text-base-content']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallcms::animation-wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['animation' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationType),'duration' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationDuration),'use-parent' => true,'class' => 'card '.e($form_card_style ?? 'bg-base-100 shadow-2xl').' w-full max-w-md shrink-0 text-base-content']); ?>
                <div class="card-body text-base-content">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($form_title ?? null): ?>
                        <h2 class="card-title"><?php echo e($form_title); ?></h2>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isPreview): ?>
                        
                        <div class="space-y-4">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $normalizedFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if (isset($component)) { $__componentOriginal2e570aa22b9478c265deeea9fec13366 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2e570aa22b9478c265deeea9fec13366 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tallcms::components.form.dynamic-field','data' => ['field' => $field,'formId' => $formId,'preview' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallcms::form.dynamic-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($field),'form-id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($formId),'preview' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2e570aa22b9478c265deeea9fec13366)): ?>
<?php $attributes = $__attributesOriginal2e570aa22b9478c265deeea9fec13366; ?>
<?php unset($__attributesOriginal2e570aa22b9478c265deeea9fec13366); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2e570aa22b9478c265deeea9fec13366)): ?>
<?php $component = $__componentOriginal2e570aa22b9478c265deeea9fec13366; ?>
<?php unset($__componentOriginal2e570aa22b9478c265deeea9fec13366); ?>
<?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <span class="btn <?php echo e($formButtonStyle); ?> w-full">
                                <?php echo e($formSubmitText); ?>

                            </span>
                        </div>
                    <?php else: ?>
                        
                        <?php
                            $formConfig = [
                                'fields' => $normalizedFields,
                                'submit_button_text' => $formSubmitText,
                                'success_message' => $form_success_message ?? 'Thanks! We\'ll be in touch.',
                                'button_style' => $formButtonStyle,
                                'redirect_page_id' => $form_redirect_page_id ?? null,
                            ];
                            $pageUrl = request()->url();
                            $signature = \TallCms\Cms\Http\Controllers\ContactFormController::signConfig($formConfig, $pageUrl);
                            $jsConfig = [
                                'formId' => $formId,
                                'submitUrl' => route('tallcms.contact.submit'),
                                'successMessage' => $formConfig['success_message'],
                                'config' => $formConfig,
                                'signature' => $signature,
                                'pageUrl' => $pageUrl,
                                'fieldNames' => array_column($formConfig['fields'], 'name'),
                            ];
                        ?>
                        <div id="<?php echo e($formId); ?>" x-data="contactForm" data-contact-form-config='<?php echo json_encode($jsConfig, 15, 512) ?>' x-cloak>
                            
                            <div x-show="formError" x-cloak class="alert alert-error mb-4">
                                <span x-text="formError"></span>
                            </div>
                            <div x-show="submitted" x-cloak class="alert alert-success">
                                <span x-text="successMessage"></span>
                            </div>
                            
                            <form x-show="!submitted" x-on:submit.prevent="submit" class="space-y-4">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $formConfig['fields']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if (isset($component)) { $__componentOriginal2e570aa22b9478c265deeea9fec13366 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2e570aa22b9478c265deeea9fec13366 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tallcms::components.form.dynamic-field','data' => ['field' => $field,'formId' => $formId]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallcms::form.dynamic-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($field),'form-id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($formId)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2e570aa22b9478c265deeea9fec13366)): ?>
<?php $attributes = $__attributesOriginal2e570aa22b9478c265deeea9fec13366; ?>
<?php unset($__attributesOriginal2e570aa22b9478c265deeea9fec13366); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2e570aa22b9478c265deeea9fec13366)): ?>
<?php $component = $__componentOriginal2e570aa22b9478c265deeea9fec13366; ?>
<?php unset($__componentOriginal2e570aa22b9478c265deeea9fec13366); ?>
<?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <div class="hidden" aria-hidden="true">
                                    <input type="text" x-model="formData._honeypot" tabindex="-1" autocomplete="off">
                                </div>
                                <button type="submit" class="btn <?php echo e($formConfig['button_style']); ?> w-full" x-bind:disabled="submitting">
                                    <span x-show="!submitting"><?php echo e($formConfig['submit_button_text']); ?></span>
                                    <span x-show="submitting" x-cloak class="loading loading-spinner loading-sm"></span>
                                </button>
                            </form>
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
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($height ?? 'min-h-[70vh]') === 'min-h-screen'): ?>
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 <?php echo e($isDarkBackground ? 'text-white/60' : 'text-base-content/60'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
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
<?php /**PATH D:\WSERV\micrandria\vendor\tallcms\cms\resources\views/cms/blocks/hero.blade.php ENDPATH**/ ?>