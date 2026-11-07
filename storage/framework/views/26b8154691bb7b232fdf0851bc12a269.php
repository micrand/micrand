<?php
    $isAccordion = ($style ?? 'accordion') === 'accordion';
    $sectionPadding = ($first_section ?? false) ? 'pb-16' : ($padding ?? 'py-16');
    $uniqueId = 'faq-' . uniqid();

    $animationType = $animation_type ?? '';
    $animationDuration = $animation_duration ?? 'anim-duration-700';
    $animationStagger = $animation_stagger ?? false;
    $staggerDelay = (int) ($animation_stagger_delay ?? 100);

    // Build anchor ID attribute (avoid @if inside tag to prevent Blade comment injection)
    $anchorIdAttr = !empty($anchor_id) ? 'id="' . e($anchor_id) . '"' : '';

    // Build x-data (avoid @if inside attribute value)
    $accordionData = $isAccordion ? "
        activeItem: " . (($first_open ?? false) ? '0' : 'null') . ",
        allowMultiple: " . (($allow_multiple ?? false) ? 'true' : 'false') . ",
        openItems: " . (($first_open ?? false) ? '[0]' : '[]') . ",
        toggle(index) {
            if (this.allowMultiple) {
                const idx = this.openItems.indexOf(index);
                if (idx > -1) {
                    this.openItems.splice(idx, 1);
                } else {
                    this.openItems.push(index);
                }
            } else {
                this.activeItem = this.activeItem === index ? null : index;
            }
        },
        isOpen(index) {
            return this.allowMultiple ? this.openItems.includes(index) : this.activeItem === index;
        }" : '';
?>


<section
    <?php echo $anchorIdAttr; ?>

    class="faq-block <?php echo e($sectionPadding); ?> <?php echo e($background ?? 'bg-base-100'); ?> <?php echo e($css_classes ?? ''); ?>"
    x-data="{
        tallcmsShown: false,
        tallcmsReducedMotion: window.matchMedia('(prefers-reduced-motion: reduce)').matches<?php echo e($isAccordion ? ',' : ''); ?><?php echo $accordionData; ?>

    }"
    x-intersect:enter.once="tallcmsShown = true"
>
    <div class="<?php echo e($contentWidthClass ?? 'max-w-6xl mx-auto'); ?> <?php echo e($contentPadding ?? 'px-4 sm:px-6 lg:px-8'); ?>">
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($heading) || !empty($subheading)): ?>
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
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($heading)): ?>
                    <h2 class="text-3xl sm:text-4xl font-bold tracking-tight text-base-content">
                        <?php echo e($heading); ?>

                    </h2>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($subheading)): ?>
                    <p class="mt-4 text-lg text-base-content/70 max-w-2xl <?php echo e(($text_alignment ?? 'text-center') === 'text-center' ? 'mx-auto' : ''); ?>">
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

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($items)): ?>
            <div class="join join-vertical w-full">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $itemDelay = $animationStagger ? ($staggerDelay * ($index + 1)) : 0;
                    ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isAccordion): ?>
                        
                        <?php if (isset($component)) { $__componentOriginalfa91448da0212bf659eadcbd610ad38e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa91448da0212bf659eadcbd610ad38e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tallcms::components.animation-wrapper','data' => ['animation' => $animationType,'duration' => $animationDuration,'useParent' => true,'delay' => $itemDelay,'class' => 'collapse collapse-arrow join-item border border-base-300 bg-base-200',':class' => '{ \'collapse-open\': isOpen('.e($index).') }']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallcms::animation-wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['animation' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationType),'duration' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationDuration),'use-parent' => true,'delay' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($itemDelay),'class' => 'collapse collapse-arrow join-item border border-base-300 bg-base-200',':class' => '{ \'collapse-open\': isOpen('.e($index).') }']); ?>
                            <input type="radio"
                                   name="<?php echo e($uniqueId); ?>"
                                   @click="toggle(<?php echo e($index); ?>)"
                                   :checked="isOpen(<?php echo e($index); ?>)"
                            />
                            <div class="collapse-title text-lg font-semibold text-base-content">
                                <?php echo e($item['question']); ?>

                            </div>
                            <div class="collapse-content">
                                <p class="text-base-content/80 leading-relaxed pt-2">
                                    <?php echo nl2br(e($item['answer'])); ?>

                                </p>
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
                    <?php else: ?>
                        
                        <?php if (isset($component)) { $__componentOriginalfa91448da0212bf659eadcbd610ad38e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa91448da0212bf659eadcbd610ad38e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tallcms::components.animation-wrapper','data' => ['animation' => $animationType,'duration' => $animationDuration,'useParent' => true,'delay' => $itemDelay,'class' => 'card bg-base-200 mb-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallcms::animation-wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['animation' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationType),'duration' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationDuration),'use-parent' => true,'delay' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($itemDelay),'class' => 'card bg-base-200 mb-4']); ?>
                            <div class="card-body">
                                <h3 class="card-title text-base-content">
                                    <?php echo e($item['question']); ?>

                                </h3>
                                <p class="text-base-content/80 leading-relaxed">
                                    <?php echo nl2br(e($item['answer'])); ?>

                                </p>
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
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($show_schema ?? true) && !empty($items)): ?>
        <?php
            $schemaItems = array_map(fn($item) => [
                '@type' => 'Question',
                'name' => $item['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $item['answer'],
                ],
            ], $items);
            $schema = [
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => $schemaItems,
            ];
        ?>
        <script type="application/ld+json"><?php echo json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?></script>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</section>
<?php /**PATH D:\WSERV\micrandria\vendor\tallcms\cms\resources\views/cms/blocks/faq.blade.php ENDPATH**/ ?>