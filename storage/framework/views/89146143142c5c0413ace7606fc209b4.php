<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(\TallCms\Cms\Models\SiteSetting::get('show_powered_by', true)): ?>
    <p class="text-xs opacity-60">
        Powered by <a href="https://tallcms.com" target="_blank" rel="noopener noreferrer" class="hover:underline">TallCMS</a>
    </p>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH D:\WSERV\micrandria\vendor\tallcms\cms\resources\views/components/powered-by.blade.php ENDPATH**/ ?>