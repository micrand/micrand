
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($renderedContent === 'WELCOME_PAGE'): ?>
    <?php echo $__env->make('welcome.tallcms', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php elseif($renderedContent === 'POST_DETAIL'): ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($templateConfig['has_sidebar'] ?? false): ?>
        
        <?php echo $__env->make($templateView, [
            'page' => $page,
            'renderedContent' => view('tallcms::partials.post-detail', [
                'post' => $post,
                'config' => $postsBlockConfig ?? [],
                'parentSlug' => $parentSlug,
                'embedded' => true,
            ])->render(),
            'allPages' => [],
            'sidebarWidgets' => $sidebarWidgets ?? [],
            'templateConfig' => $templateConfig ?? [],
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php else: ?>
        
        <?php echo $__env->make('cms.posts.show', [
            'post' => $post,
            'config' => $postsBlockConfig ?? [],
            'parentSlug' => $parentSlug,
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php else: ?>
    
    <?php echo $__env->make($templateView ?? 'tallcms::templates.default', [
        'page' => $page,
        'renderedContent' => $renderedContent,
        'allPages' => $allPages,
        'sidebarWidgets' => $sidebarWidgets ?? [],
        'templateConfig' => $templateConfig ?? [],
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH D:\WSERV\micrandria\resources\views/vendor/tallcms/livewire/page.blade.php ENDPATH**/ ?>