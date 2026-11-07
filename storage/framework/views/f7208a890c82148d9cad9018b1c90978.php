<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(config('tallcms.search.enabled', true)): ?>
<div x-data="{ open: false }">
    
    <form action="<?php echo e(tallcms_search_url()); ?>" method="GET" class="hidden lg:block">
        <div class="form-control">
            <div class="join">
                <input
                    type="search"
                    name="q"
                    placeholder="<?php echo e(__('Search...')); ?>"
                    class="input input-sm input-bordered w-40 focus:w-56 transition-all duration-200 join-item"
                    minlength="<?php echo e(config('tallcms.search.min_query_length', 2)); ?>"
                />
                <button type="submit" class="btn btn-sm btn-ghost btn-square join-item">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        </div>
    </form>

    
    <button
        @click="open = true"
        class="btn btn-ghost btn-circle lg:hidden"
        aria-label="<?php echo e(__('Search')); ?>"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
    </button>

    
    <div
        x-show="open"
        x-cloak
        x-transition:enter="ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-start justify-center pt-20 px-4 bg-base-300/80 backdrop-blur-sm lg:hidden"
        @click.self="open = false"
        @keydown.escape.window="open = false"
    >
        <div
            x-show="open"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="w-full max-w-md bg-base-100 rounded-box shadow-2xl p-4 relative"
        >
            <form action="<?php echo e(tallcms_search_url()); ?>" method="GET">
                <div class="form-control">
                    <div class="join w-full">
                        <input
                            type="search"
                            name="q"
                            placeholder="<?php echo e(__('Search pages and posts...')); ?>"
                            class="input input-bordered flex-1 join-item"
                            minlength="<?php echo e(config('tallcms.search.min_query_length', 2)); ?>"
                            x-ref="mobileSearch"
                            x-init="$watch('open', value => { if (value) setTimeout(() => $refs.mobileSearch.focus(), 100) })"
                        />
                        <button type="submit" class="btn btn-primary join-item">
                            <?php echo e(__('Search')); ?>

                        </button>
                    </div>
                </div>
            </form>
            <button
                @click="open = false"
                class="btn btn-sm btn-ghost btn-circle absolute top-2 right-2"
                aria-label="<?php echo e(__('Close')); ?>"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH D:\WSERV\micrandria\themes\talldaisy/resources/views/components/header-search.blade.php ENDPATH**/ ?>