<?php
    use TallCms\Cms\Models\CmsPost;
    use TallCms\Cms\Models\CmsCategory;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;

    // Block configuration with defaults
    $configCategories = $categories ?? [];
    $layout = $layout ?? 'grid';
    $columns = $columns ?? '3';
    $postsCount = (int) ($posts_count ?? 6);
    $offset = (int) ($offset ?? 0);
    $sortBy = $sort_by ?? 'newest';
    $pinnedPosts = $pinned_posts ?? [];
    $featuredOnly = $featured_only ?? false;
    $showImage = $show_image ?? true;
    $showExcerpt = $show_excerpt ?? true;
    $showDate = $show_date ?? true;
    $showAuthor = $show_author ?? false;
    $showCategories = $show_categories ?? true;
    $showReadMore = $show_read_more ?? true;
    $emptyMessage = $empty_message ?? 'No posts found.';
    $firstSection = $first_section ?? false;
    $sectionBackground = $background ?? 'bg-base-100';
    $sectionPaddingClass = $padding ?? 'py-16';
    $isPreview = $isPreview ?? false;

    // Featured badge settings with static class mapping
    $showFeaturedBadge = $show_featured_badge ?? false;
    $featuredBadgeStyle = $featured_badge_style ?? 'badge';
    $featuredBadgeColorKey = $featured_badge_color ?? 'warning';
    $featuredCardStyle = $featured_card_style ?? 'default';

    // Static class maps for Tailwind JIT compatibility
    $badgeClassMap = [
        'primary' => 'badge-primary',
        'secondary' => 'badge-secondary',
        'accent' => 'badge-accent',
        'warning' => 'badge-warning',
    ];
    $textClassMap = [
        'primary' => 'text-primary',
        'secondary' => 'text-secondary',
        'accent' => 'text-accent',
        'warning' => 'text-warning',
    ];
    $bgClassMap = [
        'primary' => 'bg-primary text-primary-content',
        'secondary' => 'bg-secondary text-secondary-content',
        'accent' => 'bg-accent text-accent-content',
        'warning' => 'bg-warning text-warning-content',
    ];

    // Card style class maps for featured posts (Tailwind JIT safe)
    $borderClassMap = [
        'primary' => 'border-2 border-primary',
        'secondary' => 'border-2 border-secondary',
        'accent' => 'border-2 border-accent',
        'warning' => 'border-2 border-warning',
    ];
    $gradientClassMap = [
        'primary' => 'bg-gradient-to-br from-base-200 to-primary/10',
        'secondary' => 'bg-gradient-to-br from-base-200 to-secondary/10',
        'accent' => 'bg-gradient-to-br from-base-200 to-accent/10',
        'warning' => 'bg-gradient-to-br from-base-200 to-warning/10',
    ];
    $ringClassMap = [
        'primary' => 'ring-1 ring-primary/20',
        'secondary' => 'ring-1 ring-secondary/20',
        'accent' => 'ring-1 ring-accent/20',
        'warning' => 'ring-1 ring-warning/20',
    ];

    $badgeClass = $badgeClassMap[$featuredBadgeColorKey] ?? 'badge-warning';
    $textClass = $textClassMap[$featuredBadgeColorKey] ?? 'text-warning';
    $bgClass = $bgClassMap[$featuredBadgeColorKey] ?? 'bg-warning text-warning-content';

    // Pagination configuration
    $enablePagination = $enable_pagination ?? false;
    $perPage = (int) ($per_page ?? 12);

    // Block UUID for pagination - use persisted UUID or generate stable fallback
    $blockUuid = $block_uuid ?? null;
    if (!$blockUuid) {
        // Fallback: use a static counter to ensure unique IDs for multiple blocks on same page
        // Combined with page slug for cross-page uniqueness
        static $blockCounter = 0;
        $blockCounter++;
        $pageSlugForId = $cmsPageSlug ?? request()->route('slug') ?? 'home';
        $blockUuid = 'legacy-' . substr(md5($pageSlugForId), 0, 4) . '-' . $blockCounter;
    }
    $paginationParam = "posts_{$blockUuid}";

    // Get parent slug - try multiple sources in order of preference:
    // 1. Passed directly to template ($parentSlug)
    // 2. Shared view data from CmsPageRenderer ($cmsPageSlug)
    // 3. Route parameter as fallback (handles direct page views)
    $parentSlug = $parentSlug
        ?? ($cmsPageSlug ?? null)
        ?? request()->route('slug')
        ?? '';

    // Check for category filter from query string
    $filterCategorySlug = request()->query('category');
    $filterCategory = $filterCategorySlug
        ? (tallcms_i18n_enabled()
            ? CmsCategory::withLocalizedSlug($filterCategorySlug)->first()
            : CmsCategory::withSlug($filterCategorySlug)->first())
        : null;

    // Determine if we should show drafts (preview mode for authenticated users)
    $showDrafts = auth()->check() && ($isPreview || request()->has('preview'));

    // Build the base query
    $query = CmsPost::query()->with(['categories', 'author']);

    // Apply publish filter (allow drafts in preview mode)
    if (!$showDrafts) {
        $query->published();
    }

    // Apply category filter - query string takes precedence over config
    $activeCategories = $filterCategory ? [$filterCategory->id] : $configCategories;
    if (!empty($activeCategories)) {
        $query->whereHas('categories', function ($q) use ($activeCategories) {
            $q->whereIn('tallcms_categories.id', $activeCategories);
        });
    }

    // Featured only filter
    if ($featuredOnly) {
        $query->featured();
    }

    // Track if we're using pagination
    $isPaginated = false;
    $posts = collect();

    // Handle sorting and retrieval
    if ($sortBy === 'manual' && !empty($pinnedPosts)) {
        // Manual selection doesn't support pagination
        $manualQuery = CmsPost::query()->with(['categories', 'author']);

        if (!$showDrafts) {
            $manualQuery->published();
        }

        if (!empty($activeCategories)) {
            $manualQuery->whereHas('categories', function ($q) use ($activeCategories) {
                $q->whereIn('tallcms_categories.id', $activeCategories);
            });
        }

        $posts = $manualQuery
            ->whereIn('id', $pinnedPosts)
            ->get()
            ->sortBy(function ($post) use ($pinnedPosts) {
                return array_search($post->id, $pinnedPosts);
            })
            ->values()
            ->skip($offset)
            ->take($postsCount);
    } else {
        switch ($sortBy) {
            case 'oldest':
                $query->orderBy('published_at', 'asc');
                break;
            case 'title_asc':
                $query->orderByRaw('LOWER(title) ASC');
                break;
            case 'title_desc':
                $query->orderByRaw('LOWER(title) DESC');
                break;
            case 'featured_first':
                $query->orderBy('is_featured', 'desc')
                      ->orderBy('published_at', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('published_at', 'desc');
                break;
        }

        // Use pagination or simple limit
        // Note: offset and pagination are mutually exclusive - offset is ignored when pagination is enabled
        if ($enablePagination && !$isPreview && $offset === 0) {
            $currentPage = (int) request()->input($paginationParam, 1);
            $posts = $query->paginate($perPage, ['*'], $paginationParam, $currentPage)
                ->withQueryString();
            $isPaginated = true;
        } else {
            // Simple limit/offset mode (no pagination)
            if ($offset > 0) {
                $query->skip($offset);
            }
            $posts = $query->limit($postsCount)->get();
        }
    }

    // Section spacing
    $sectionPadding = $firstSection ? 'pb-16' : $sectionPaddingClass;

    // Animation config
    $animationType = $animation_type ?? '';
    $animationDuration = $animation_duration ?? 'anim-duration-700';
    $animationStagger = $animation_stagger ?? false;
    $staggerDelay = (int) ($animation_stagger_delay ?? 100);

    // Grid column classes
    $gridColumnClass = match($columns) {
        '2' => 'sm:grid-cols-2',
        '4' => 'sm:grid-cols-2 lg:grid-cols-4',
        default => 'sm:grid-cols-2 lg:grid-cols-3'
    };

    // Helper to generate post URL (uses localized URL helper)
    $getPostUrl = function($post) use ($parentSlug, $isPreview) {
        if ($isPreview) {
            return '#';
        }
        // Get the localized post slug
        $postSlug = tallcms_i18n_enabled()
            ? ($post->getTranslation('slug', app()->getLocale(), false) ?? $post->slug)
            : $post->slug;

        // Build full slug with parent
        $fullSlug = empty($parentSlug) ? $postSlug : $parentSlug . '/' . $postSlug;
        return tallcms_localized_url($fullSlug);
    };

    // Helper to generate category filter URL (uses localized URL helper)
    $getCategoryFilterUrl = function($category) use ($parentSlug, $isPreview) {
        if ($isPreview) {
            return '#';
        }
        // Get the localized category slug
        $categorySlug = tallcms_i18n_enabled()
            ? ($category->getTranslation('slug', app()->getLocale(), false) ?? $category->slug)
            : $category->slug;

        if (empty($parentSlug)) {
            return tallcms_localized_url('/') . '?category=' . $categorySlug;
        }
        return tallcms_localized_url($parentSlug) . '?category=' . $categorySlug;
    };

    // Helper to generate clear filter URL (uses localized URL helper)
    $getClearFilterUrl = function() use ($parentSlug, $isPreview) {
        if ($isPreview) {
            return '#';
        }
        if (empty($parentSlug)) {
            return tallcms_localized_url('/');
        }
        return tallcms_localized_url($parentSlug);
    };
?>

<?php if (isset($component)) { $__componentOriginalfa91448da0212bf659eadcbd610ad38e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa91448da0212bf659eadcbd610ad38e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tallcms::components.animation-wrapper','data' => ['tag' => 'section','animation' => $animationType,'controller' => true,'id' => $anchor_id ?? null,'class' => 'posts-block '.e($sectionPadding).' '.e($sectionBackground).' '.e($css_classes ?? '').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallcms::animation-wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tag' => 'section','animation' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationType),'controller' => true,'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($anchor_id ?? null),'class' => 'posts-block '.e($sectionPadding).' '.e($sectionBackground).' '.e($css_classes ?? '').'']); ?>
    <div class="<?php echo e($contentWidthClass ?? 'max-w-6xl mx-auto'); ?> <?php echo e($contentPadding ?? 'px-4 sm:px-6 lg:px-8'); ?>">
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($filterCategory): ?>
            <div class="mb-6 flex items-center gap-2">
                <span class="text-sm text-base-content/70">Filtering by:</span>
                <span class="badge badge-lg gap-1" style="background-color: <?php echo e($filterCategory->color ?? 'var(--p)'); ?>20; color: <?php echo e($filterCategory->color ?? 'var(--p)'); ?>;">
                    <?php echo e($filterCategory->name); ?>

                    <a
                        href="<?php echo e($getClearFilterUrl()); ?>"
                        class="ml-1 hover:opacity-70"
                        title="Clear filter"
                    >
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-m-x-mark'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                    </a>
                </span>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($posts->isEmpty()): ?>
            
            <div class="text-center py-12">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-document-text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mx-auto h-12 w-12 text-base-content/40']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                <p class="mt-4 text-lg text-base-content/70">
                    <?php echo e($emptyMessage); ?>

                </p>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($filterCategory): ?>
                    <a
                        href="<?php echo e($getClearFilterUrl()); ?>"
                        class="mt-4 inline-flex items-center link link-primary"
                    >
                        View all posts
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php else: ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($layout === 'featured-hero'): ?>
                
                <?php
                    // Separate featured and regular posts
                    // Take first featured post for hero, put remaining featured + all regular in grid
                    $featuredPosts = $posts->filter(fn($p) => $p->is_featured);
                    $heroPost = $featuredPosts->first();
                    $remainingFeatured = $featuredPosts->skip(1);
                    $regularPosts = $posts->filter(fn($p) => !$p->is_featured);
                    // Combine remaining featured + regular for the grid, normalize keys for consistent stagger delays
                    $gridPosts = $remainingFeatured->concat($regularPosts)->values();
                ?>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($heroPost): ?>
                    <?php
                        $heroUrl = $getPostUrl($heroPost);
                        $heroHasImage = $showImage && $heroPost->featured_image;
                    ?>
                    <?php if (isset($component)) { $__componentOriginalfa91448da0212bf659eadcbd610ad38e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa91448da0212bf659eadcbd610ad38e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tallcms::components.animation-wrapper','data' => ['animation' => $animationType,'duration' => $animationDuration,'useParent' => true,'delay' => 0]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallcms::animation-wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['animation' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationType),'duration' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationDuration),'use-parent' => true,'delay' => 0]); ?>
                        <div class="mb-8">
                            <article class="card <?php echo e($heroHasImage ? 'lg:card-side' : ''); ?> bg-base-200 shadow-lg relative overflow-hidden">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($heroHasImage): ?>
                                    <figure class="lg:w-1/2">
                                        <a href="<?php echo e($heroUrl); ?>" class="block">
                                            <img src="<?php echo e(Storage::disk(cms_media_disk())->url($heroPost->featured_image)); ?>"
                                                 alt="<?php echo e($heroPost->title); ?>"
                                                 class="w-full h-64 lg:h-80 object-cover">
                                        </a>
                                    </figure>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <div class="card-body <?php echo e($heroHasImage ? 'lg:w-1/2' : ''); ?>">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showFeaturedBadge): ?>
                                        <span class="badge <?php echo e($badgeClass); ?> gap-1 w-fit">
                                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-s-star'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-3 h-3']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                            Featured
                                        </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showCategories && $heroPost->categories->isNotEmpty()): ?>
                                        <div class="flex flex-wrap gap-2">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $heroPost->categories->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <a
                                                    href="<?php echo e($getCategoryFilterUrl($category)); ?>"
                                                    class="badge badge-sm hover:opacity-80 transition-opacity"
                                                    style="background-color: <?php echo e($category->color ?? 'var(--p)'); ?>20; color: <?php echo e($category->color ?? 'var(--p)'); ?>;"
                                                >
                                                    <?php echo e($category->name); ?>

                                                </a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <h2 class="card-title text-2xl lg:text-3xl">
                                        <a href="<?php echo e($heroUrl); ?>" class="hover:underline text-base-content">
                                            <?php echo e($heroPost->title); ?>

                                        </a>
                                    </h2>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showDate || $showAuthor): ?>
                                        <div class="flex items-center gap-2 text-sm text-base-content/60">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showDate && $heroPost->published_at): ?>
                                                <time datetime="<?php echo e($heroPost->published_at->toISOString()); ?>">
                                                    <?php echo e($heroPost->published_at->format('M j, Y')); ?>

                                                </time>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showDate && $showAuthor && $heroPost->author): ?>
                                                <span>&middot;</span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showAuthor && $heroPost->author): ?>
                                                <span><?php echo e($heroPost->author->name); ?></span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showExcerpt && $heroPost->excerpt): ?>
                                        <p class="text-base-content/70 line-clamp-3"><?php echo e($heroPost->excerpt); ?></p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showReadMore): ?>
                                        <div class="card-actions justify-start mt-4">
                                            <a href="<?php echo e($heroUrl); ?>" class="btn btn-primary">
                                                Read more
                                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-m-arrow-right'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                            </a>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </article>
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

                
                <?php
                    $postsForGrid = $heroPost ? $gridPosts : $posts;
                    $heroOffset = $heroPost ? 1 : 0; // Offset animation delay if hero exists
                ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($postsForGrid->isNotEmpty()): ?>
                    <div class="grid gap-6 sm:gap-8 <?php echo e($gridColumnClass); ?>">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $postsForGrid; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $postUrl = $getPostUrl($post);
                                $itemDelay = $animationStagger ? ($staggerDelay * ($index + 1 + $heroOffset)) : 0;
                                $isFeatured = $post->is_featured;
                                $baseCardClass = 'card shadow-sm hover:shadow-md transition-shadow duration-200 h-full relative';
                                $cardBgClass = 'bg-base-200';
                                $cardExtraClass = '';

                                if ($isFeatured && $featuredCardStyle !== 'default') {
                                    $cardExtraClass = match($featuredCardStyle) {
                                        'border' => $borderClassMap[$featuredBadgeColorKey] ?? 'border-2 border-warning',
                                        'gradient' => '',
                                        'elevated' => 'shadow-lg hover:shadow-xl ' . ($ringClassMap[$featuredBadgeColorKey] ?? 'ring-1 ring-warning/20'),
                                        default => '',
                                    };

                                    if ($featuredCardStyle === 'gradient') {
                                        $cardBgClass = $gradientClassMap[$featuredBadgeColorKey] ?? 'bg-gradient-to-br from-base-200 to-warning/10';
                                    }
                                }
                            ?>
                            <?php if (isset($component)) { $__componentOriginalfa91448da0212bf659eadcbd610ad38e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa91448da0212bf659eadcbd610ad38e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tallcms::components.animation-wrapper','data' => ['animation' => $animationType,'duration' => $animationDuration,'useParent' => true,'delay' => $itemDelay]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallcms::animation-wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['animation' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationType),'duration' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationDuration),'use-parent' => true,'delay' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($itemDelay)]); ?>
                                <article class="<?php echo e($baseCardClass); ?> <?php echo e($cardBgClass); ?> <?php echo e($cardExtraClass); ?>">
                                    
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showFeaturedBadge && $isFeatured): ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($featuredBadgeStyle === 'star'): ?>
                                            <div class="absolute top-2 right-2 z-10">
                                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-s-star'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-6 h-6 '.e($textClass).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                            </div>
                                        <?php elseif($featuredBadgeStyle === 'ribbon'): ?>
                                            <div class="absolute top-0 right-0 overflow-hidden w-20 h-20 z-10">
                                                <div class="absolute transform rotate-45 <?php echo e($bgClass); ?> text-xs font-bold py-1 right-[-35px] top-[15px] w-[120px] text-center shadow-sm">
                                                    Featured
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="absolute top-2 left-2 z-10">
                                                <span class="badge <?php echo e($badgeClass); ?> badge-sm gap-1">
                                                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-s-star'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-3 h-3']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                                    Featured
                                                </span>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showImage && $post->featured_image): ?>
                                        <figure>
                                            <a href="<?php echo e($postUrl); ?>" class="block">
                                                <img
                                                    src="<?php echo e(Storage::disk(cms_media_disk())->url($post->featured_image)); ?>"
                                                    alt="<?php echo e($post->title); ?>"
                                                    class="w-full h-48 object-cover"
                                                    loading="lazy"
                                                >
                                            </a>
                                        </figure>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <div class="card-body">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showCategories && $post->categories->isNotEmpty()): ?>
                                            <div class="flex flex-wrap gap-2 mb-2">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $post->categories->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <a
                                                        href="<?php echo e($getCategoryFilterUrl($category)); ?>"
                                                        class="badge badge-sm hover:opacity-80 transition-opacity"
                                                        style="background-color: <?php echo e($category->color ?? 'var(--p)'); ?>20; color: <?php echo e($category->color ?? 'var(--p)'); ?>;"
                                                    >
                                                        <?php echo e($category->name); ?>

                                                    </a>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                        <h3 class="card-title text-lg">
                                            <a href="<?php echo e($postUrl); ?>" class="hover:underline text-base-content">
                                                <?php echo e($post->title); ?>

                                            </a>
                                        </h3>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showDate || $showAuthor): ?>
                                            <div class="flex items-center gap-2 text-sm text-base-content/60">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showDate && $post->published_at): ?>
                                                    <time datetime="<?php echo e($post->published_at->toISOString()); ?>">
                                                        <?php echo e($post->published_at->format('M j, Y')); ?>

                                                    </time>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showDate && $showAuthor && $post->author): ?>
                                                    <span>&middot;</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showAuthor && $post->author): ?>
                                                    <span><?php echo e($post->author->name); ?></span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showExcerpt && $post->excerpt): ?>
                                            <p class="text-sm text-base-content/70 line-clamp-3">
                                                <?php echo e($post->excerpt); ?>

                                            </p>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showReadMore): ?>
                                            <div class="card-actions justify-start mt-2">
                                                <a href="<?php echo e($postUrl); ?>" class="link link-primary link-hover text-sm inline-flex items-center">
                                                    Read more
                                                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-m-arrow-right'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 ml-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                                </a>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </article>
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
            <?php elseif($layout === 'grid'): ?>
                
                <div class="grid gap-6 sm:gap-8 <?php echo e($gridColumnClass); ?>">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $postUrl = $getPostUrl($post);
                            $itemDelay = $animationStagger ? ($staggerDelay * ($index + 1)) : 0;
                            $isFeatured = $post->is_featured;
                            $baseCardClass = 'card shadow-sm hover:shadow-md transition-shadow duration-200 h-full relative';
                            $cardBgClass = 'bg-base-200';
                            $cardExtraClass = '';

                            if ($isFeatured && $featuredCardStyle !== 'default') {
                                $cardExtraClass = match($featuredCardStyle) {
                                    'border' => $borderClassMap[$featuredBadgeColorKey] ?? 'border-2 border-warning',
                                    'gradient' => '',
                                    'elevated' => 'shadow-lg hover:shadow-xl ' . ($ringClassMap[$featuredBadgeColorKey] ?? 'ring-1 ring-warning/20'),
                                    default => '',
                                };

                                if ($featuredCardStyle === 'gradient') {
                                    $cardBgClass = $gradientClassMap[$featuredBadgeColorKey] ?? 'bg-gradient-to-br from-base-200 to-warning/10';
                                }
                            }
                        ?>
                        <?php if (isset($component)) { $__componentOriginalfa91448da0212bf659eadcbd610ad38e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa91448da0212bf659eadcbd610ad38e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tallcms::components.animation-wrapper','data' => ['animation' => $animationType,'duration' => $animationDuration,'useParent' => true,'delay' => $itemDelay]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallcms::animation-wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['animation' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationType),'duration' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationDuration),'use-parent' => true,'delay' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($itemDelay)]); ?>
                            <article class="<?php echo e($baseCardClass); ?> <?php echo e($cardBgClass); ?> <?php echo e($cardExtraClass); ?>">
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showFeaturedBadge && $isFeatured): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($featuredBadgeStyle === 'star'): ?>
                                        <div class="absolute top-2 right-2 z-10">
                                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-s-star'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-6 h-6 '.e($textClass).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                        </div>
                                    <?php elseif($featuredBadgeStyle === 'ribbon'): ?>
                                        <div class="absolute top-0 right-0 overflow-hidden w-20 h-20 z-10">
                                            <div class="absolute transform rotate-45 <?php echo e($bgClass); ?> text-xs font-bold py-1 right-[-35px] top-[15px] w-[120px] text-center shadow-sm">
                                                Featured
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="absolute top-2 left-2 z-10">
                                            <span class="badge <?php echo e($badgeClass); ?> badge-sm gap-1">
                                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-s-star'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-3 h-3']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                                Featured
                                            </span>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showImage && $post->featured_image): ?>
                                <figure>
                                    <a href="<?php echo e($postUrl); ?>" class="block">
                                        <img
                                            src="<?php echo e(Storage::disk(cms_media_disk())->url($post->featured_image)); ?>"
                                            alt="<?php echo e($post->title); ?>"
                                            class="w-full h-48 object-cover"
                                            loading="lazy"
                                        >
                                    </a>
                                </figure>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <div class="card-body">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showCategories && $post->categories->isNotEmpty()): ?>
                                    <div class="flex flex-wrap gap-2 mb-2">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $post->categories->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a
                                                href="<?php echo e($getCategoryFilterUrl($category)); ?>"
                                                class="badge badge-sm hover:opacity-80 transition-opacity"
                                                style="background-color: <?php echo e($category->color ?? 'var(--p)'); ?>20; color: <?php echo e($category->color ?? 'var(--p)'); ?>;"
                                            >
                                                <?php echo e($category->name); ?>

                                            </a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <h3 class="card-title text-lg">
                                    <a href="<?php echo e($postUrl); ?>" class="hover:underline text-base-content">
                                        <?php echo e($post->title); ?>

                                    </a>
                                </h3>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showDate || $showAuthor): ?>
                                    <div class="flex items-center gap-2 text-sm text-base-content/60">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showDate && $post->published_at): ?>
                                            <time datetime="<?php echo e($post->published_at->toISOString()); ?>">
                                                <?php echo e($post->published_at->format('M j, Y')); ?>

                                            </time>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showDate && $showAuthor && $post->author): ?>
                                            <span>&middot;</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showAuthor && $post->author): ?>
                                            <span><?php echo e($post->author->name); ?></span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showExcerpt && $post->excerpt): ?>
                                    <p class="text-sm text-base-content/70 line-clamp-3">
                                        <?php echo e($post->excerpt); ?>

                                    </p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showReadMore): ?>
                                    <div class="card-actions justify-start mt-2">
                                        <a href="<?php echo e($postUrl); ?>" class="link link-primary link-hover text-sm inline-flex items-center">
                                            Read more
                                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-m-arrow-right'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 ml-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                        </a>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </article>
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
                
                <div class="space-y-6">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $postUrl = $getPostUrl($post);
                            $itemDelay = $animationStagger ? ($staggerDelay * ($index + 1)) : 0;
                            $isFeatured = $post->is_featured;
                            $isCompact = $layout === 'compact-list';

                            // Base classes for list layout
                            $baseListClass = 'card card-side shadow-sm hover:shadow-md transition-shadow duration-200 relative';
                            $listBgClass = 'bg-base-200';
                            $listExtraClass = '';

                            if ($isCompact) {
                                $baseListClass = 'card card-side py-2 border-b border-base-300 relative';
                                $listBgClass = 'bg-transparent';
                                $listExtraClass = 'shadow-none';
                            } elseif ($isFeatured && $featuredCardStyle !== 'default') {
                                $listExtraClass = match($featuredCardStyle) {
                                    'border' => $borderClassMap[$featuredBadgeColorKey] ?? 'border-2 border-warning',
                                    'gradient' => '',
                                    'elevated' => 'shadow-lg hover:shadow-xl ' . ($ringClassMap[$featuredBadgeColorKey] ?? 'ring-1 ring-warning/20'),
                                    default => '',
                                };

                                if ($featuredCardStyle === 'gradient') {
                                    $listBgClass = $gradientClassMap[$featuredBadgeColorKey] ?? 'bg-gradient-to-br from-base-200 to-warning/10';
                                }
                            }
                        ?>
                        <?php if (isset($component)) { $__componentOriginalfa91448da0212bf659eadcbd610ad38e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa91448da0212bf659eadcbd610ad38e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tallcms::components.animation-wrapper','data' => ['animation' => $animationType,'duration' => $animationDuration,'useParent' => true,'delay' => $itemDelay]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallcms::animation-wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['animation' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationType),'duration' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($animationDuration),'use-parent' => true,'delay' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($itemDelay)]); ?>
                            <article class="<?php echo e($baseListClass); ?> <?php echo e($listBgClass); ?> <?php echo e($listExtraClass); ?>">
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showFeaturedBadge && $isFeatured && !$isCompact): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($featuredBadgeStyle === 'star'): ?>
                                        <div class="absolute top-2 right-2 z-10">
                                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-s-star'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-6 h-6 '.e($textClass).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                        </div>
                                    <?php elseif($featuredBadgeStyle === 'ribbon'): ?>
                                        <div class="absolute top-0 right-0 overflow-hidden w-20 h-20 z-10">
                                            <div class="absolute transform rotate-45 <?php echo e($bgClass); ?> text-xs font-bold py-1 right-[-35px] top-[15px] w-[120px] text-center shadow-sm">
                                                Featured
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="absolute top-2 left-2 z-10">
                                            <span class="badge <?php echo e($badgeClass); ?> badge-sm gap-1">
                                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-s-star'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-3 h-3']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                                Featured
                                            </span>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showImage && $post->featured_image && !$isCompact): ?>
                                <figure class="flex-shrink-0">
                                    <a href="<?php echo e($postUrl); ?>">
                                        <img
                                            src="<?php echo e(Storage::disk(cms_media_disk())->url($post->featured_image)); ?>"
                                            alt="<?php echo e($post->title); ?>"
                                            class="w-48 h-32 object-cover rounded-l-xl"
                                            loading="lazy"
                                        >
                                    </a>
                                </figure>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <div class="card-body py-4">
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showFeaturedBadge && $isFeatured && $isCompact): ?>
                                    <span class="badge <?php echo e($badgeClass); ?> badge-sm gap-1 w-fit mb-1">
                                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-s-star'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-3 h-3']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                        Featured
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showCategories && $post->categories->isNotEmpty() && !$isCompact): ?>
                                    <div class="flex flex-wrap gap-2 mb-1">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $post->categories->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a
                                                href="<?php echo e($getCategoryFilterUrl($category)); ?>"
                                                class="badge badge-sm hover:opacity-80 transition-opacity"
                                                style="background-color: <?php echo e($category->color ?? 'var(--p)'); ?>20; color: <?php echo e($category->color ?? 'var(--p)'); ?>;"
                                            >
                                                <?php echo e($category->name); ?>

                                            </a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <h3 class="card-title <?php echo e($isCompact ? 'text-base' : 'text-xl'); ?>">
                                    <a href="<?php echo e($postUrl); ?>" class="hover:underline text-base-content">
                                        <?php echo e($post->title); ?>

                                    </a>
                                </h3>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showDate || $showAuthor): ?>
                                    <div class="flex items-center gap-2 text-sm text-base-content/60">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showDate && $post->published_at): ?>
                                            <time datetime="<?php echo e($post->published_at->toISOString()); ?>">
                                                <?php echo e($post->published_at->format('M j, Y')); ?>

                                            </time>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showDate && $showAuthor && $post->author): ?>
                                            <span>&middot;</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showAuthor && $post->author): ?>
                                            <span><?php echo e($post->author->name); ?></span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showExcerpt && $post->excerpt && !$isCompact): ?>
                                    <p class="text-sm text-base-content/70 line-clamp-2">
                                        <?php echo e($post->excerpt); ?>

                                    </p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showReadMore && !$isCompact): ?>
                                    <div class="card-actions justify-start mt-1">
                                        <a href="<?php echo e($postUrl); ?>" class="link link-primary link-hover text-sm inline-flex items-center">
                                            Read more
                                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-m-arrow-right'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 ml-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                        </a>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </article>
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

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isPaginated && $posts->hasPages()): ?>
                <div class="mt-8">
                    <?php if (isset($component)) { $__componentOriginal30778eaf050ab315b9daf6e0a60e4fe7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30778eaf050ab315b9daf6e0a60e4fe7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tallcms::components.pagination','data' => ['paginator' => $posts,'paramName' => $paginationParam]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallcms::pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['paginator' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($posts),'paramName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($paginationParam)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal30778eaf050ab315b9daf6e0a60e4fe7)): ?>
<?php $attributes = $__attributesOriginal30778eaf050ab315b9daf6e0a60e4fe7; ?>
<?php unset($__attributesOriginal30778eaf050ab315b9daf6e0a60e4fe7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal30778eaf050ab315b9daf6e0a60e4fe7)): ?>
<?php $component = $__componentOriginal30778eaf050ab315b9daf6e0a60e4fe7; ?>
<?php unset($__componentOriginal30778eaf050ab315b9daf6e0a60e4fe7); ?>
<?php endif; ?>
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
<?php /**PATH D:\WSERV\micrandria\vendor\tallcms\cms\resources\views/cms/blocks/posts.blade.php ENDPATH**/ ?>