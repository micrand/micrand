
<div class="cms-content w-full">
    
    <section id="content" data-content-width="<?php echo e($page->content_width ?? 'standard'); ?>">
        <?php echo $renderedContent; ?>

    </section>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $allPages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pageData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <section id="<?php echo e($pageData['anchor']); ?>" data-content-width="<?php echo e($pageData['content_width'] ?? 'standard'); ?>">
            <?php echo $pageData['content']; ?>

        </section>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH D:\WSERV\micrandria\vendor\tallcms\cms\resources\views/templates/default.blade.php ENDPATH**/ ?>