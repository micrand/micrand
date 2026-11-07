<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'type' => 'webpage',
    'data' => null,
    'page' => null,
    'post' => null,
    'breadcrumbs' => null,
    'includeWebsite' => false,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'type' => 'webpage',
    'data' => null,
    'page' => null,
    'post' => null,
    'breadcrumbs' => null,
    'includeWebsite' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    use TallCms\Cms\Services\SeoService;

    $schemas = [];

    // Add WebSite schema for homepage
    if ($includeWebsite) {
        $schemas[] = SeoService::getWebsiteJsonLd();
    }

    // Add page-specific schema
    if ($page) {
        $schemas[] = SeoService::getPageJsonLd($page);
    }

    // Add post-specific schema (Article/BlogPosting)
    if ($post) {
        $schemas[] = SeoService::getPostJsonLd($post);
    }

    // Add custom data if provided
    if ($data) {
        $schemas[] = $data;
    }

    // Add breadcrumbs if provided
    if ($breadcrumbs && count($breadcrumbs) > 0) {
        $schemas[] = SeoService::getBreadcrumbJsonLd($breadcrumbs);
    }
?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $schemas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schema): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<script type="application/ld+json">
<?php echo json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); ?>

</script>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH D:\WSERV\micrandria\vendor\tallcms\cms\resources\views/components/seo/structured-data.blade.php ENDPATH**/ ?>