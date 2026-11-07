<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" data-theme="<?php echo e(daisyui_default_preset()); ?>" data-default-theme="<?php echo e(daisyui_default_preset()); ?>">
<head>
    <script>
        // Apply saved theme immediately to prevent flash of wrong theme
        // When admin changes the default preset, localStorage is cleared so the new default wins
        (function() {
            var serverDefault = document.documentElement.getAttribute('data-default-theme');
            var storedDefault = localStorage.getItem('theme-default');
            if (storedDefault !== serverDefault) {
                // Admin changed the default — clear visitor's override
                localStorage.removeItem('theme');
                localStorage.setItem('theme-default', serverDefault);
            }
            var savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                document.documentElement.setAttribute('data-theme', savedTheme);
            }
        })();
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
    <?php if (isset($component)) { $__componentOriginalee9b4896b1c99380af96e0e258c907dc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalee9b4896b1c99380af96e0e258c907dc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tallcms::components.seo.meta-tags','data' => ['title' => $title ?? null,'description' => $description ?? null,'image' => isset($featuredImage) && $featuredImage ? Storage::disk(cms_media_disk())->url($featuredImage) : null,'type' => $seoType ?? 'website','article' => $seoArticle ?? null,'twitter' => $seoTwitter ?? null,'profile' => $seoProfile ?? null]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallcms::seo.meta-tags'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($title ?? null),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($description ?? null),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($featuredImage) && $featuredImage ? Storage::disk(cms_media_disk())->url($featuredImage) : null),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($seoType ?? 'website'),'article' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($seoArticle ?? null),'twitter' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($seoTwitter ?? null),'profile' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($seoProfile ?? null)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalee9b4896b1c99380af96e0e258c907dc)): ?>
<?php $attributes = $__attributesOriginalee9b4896b1c99380af96e0e258c907dc; ?>
<?php unset($__attributesOriginalee9b4896b1c99380af96e0e258c907dc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalee9b4896b1c99380af96e0e258c907dc)): ?>
<?php $component = $__componentOriginalee9b4896b1c99380af96e0e258c907dc; ?>
<?php unset($__componentOriginalee9b4896b1c99380af96e0e258c907dc); ?>
<?php endif; ?>

    
    <?php if (isset($component)) { $__componentOriginal4508b4ff3a35001ff0673d3834e5ac17 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4508b4ff3a35001ff0673d3834e5ac17 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tallcms::components.seo.structured-data','data' => ['page' => $seoPage ?? null,'post' => $seoPost ?? null,'breadcrumbs' => $seoBreadcrumbs ?? null,'includeWebsite' => $seoIncludeWebsite ?? false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallcms::seo.structured-data'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['page' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($seoPage ?? null),'post' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($seoPost ?? null),'breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($seoBreadcrumbs ?? null),'includeWebsite' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($seoIncludeWebsite ?? false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4508b4ff3a35001ff0673d3834e5ac17)): ?>
<?php $attributes = $__attributesOriginal4508b4ff3a35001ff0673d3834e5ac17; ?>
<?php unset($__attributesOriginal4508b4ff3a35001ff0673d3834e5ac17); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4508b4ff3a35001ff0673d3834e5ac17)): ?>
<?php $component = $__componentOriginal4508b4ff3a35001ff0673d3834e5ac17; ?>
<?php unset($__componentOriginal4508b4ff3a35001ff0673d3834e5ac17); ?>
<?php endif; ?>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <!-- Favicon -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($favicon = \TallCms\Cms\Models\SiteSetting::get('favicon')): ?>
        <link rel="icon" href="<?php echo e(Storage::disk(cms_media_disk())->url($favicon)); ?>">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- CMS Core Runtime (shared Alpine components) -->
    <?php echo app(\TallCms\Cms\Services\ThemeManager::class)->getCoreJsTag(); ?>
    <!-- Theme Assets -->
    <?php $themeAssets = app('theme.manager')->getThemeViteAssets(['resources/css/app.css', 'resources/js/app.js']);
                     foreach($themeAssets as $asset):
                         if($asset['type'] === 'css'):
                             echo '<link rel="stylesheet" href="' . $asset['url'] . '">';
                         else:
                             echo '<script type="module" src="' . $asset['url'] . '"></script>';
                         endif;
                     endforeach; ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    <style>
        [x-cloak] { display: none !important; }
        html { scroll-behavior: smooth; }

        /* Navigation progress bar */
        #nav-progress {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: oklch(var(--p));
            z-index: 9999;
            transform: scaleX(0);
            transform-origin: left;
            pointer-events: none;
        }
        #nav-progress.loading {
            animation: nav-progress 2s ease-out forwards;
        }
        #nav-progress.done {
            animation: none;
            transform: scaleX(1);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        @keyframes nav-progress {
            0% { transform: scaleX(0); }
            20% { transform: scaleX(0.5); }
            80% { transform: scaleX(0.8); }
            100% { transform: scaleX(0.95); }
        }

        /* Content fade during navigation */
        .page-transitioning {
            opacity: 0.5;
            transition: opacity 0.1s ease;
        }
    </style>
    <?php if (isset($component)) { $__componentOriginal804566c8365d02f249b074a86f8bbb00 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal804566c8365d02f249b074a86f8bbb00 = $attributes; } ?>
<?php $component = TallCms\Cms\View\Components\CodeInjection::resolve(['zone' => 'head'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallcms::code-injection'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallCms\Cms\View\Components\CodeInjection::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal804566c8365d02f249b074a86f8bbb00)): ?>
<?php $attributes = $__attributesOriginal804566c8365d02f249b074a86f8bbb00; ?>
<?php unset($__attributesOriginal804566c8365d02f249b074a86f8bbb00); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal804566c8365d02f249b074a86f8bbb00)): ?>
<?php $component = $__componentOriginal804566c8365d02f249b074a86f8bbb00; ?>
<?php unset($__componentOriginal804566c8365d02f249b074a86f8bbb00); ?>
<?php endif; ?>
</head>
<body class="min-h-screen bg-base-100 text-base-content">
    <?php if (isset($component)) { $__componentOriginal804566c8365d02f249b074a86f8bbb00 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal804566c8365d02f249b074a86f8bbb00 = $attributes; } ?>
<?php $component = TallCms\Cms\View\Components\CodeInjection::resolve(['zone' => 'body_start'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallcms::code-injection'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallCms\Cms\View\Components\CodeInjection::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal804566c8365d02f249b074a86f8bbb00)): ?>
<?php $attributes = $__attributesOriginal804566c8365d02f249b074a86f8bbb00; ?>
<?php unset($__attributesOriginal804566c8365d02f249b074a86f8bbb00); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal804566c8365d02f249b074a86f8bbb00)): ?>
<?php $component = $__componentOriginal804566c8365d02f249b074a86f8bbb00; ?>
<?php unset($__componentOriginal804566c8365d02f249b074a86f8bbb00); ?>
<?php endif; ?>
    <!-- Navigation Progress Bar -->
    <div class="navigation-progress" id="nav-progress"></div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(supports_theme_controller()): ?>
    <!-- Theme Drawer Wrapper -->
    <div class="drawer drawer-end">
        <input id="theme-drawer" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <!-- Navbar -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(function_exists('mega_menu_header_active') && mega_menu_header_active('header')): ?>
                
                <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => 'mega-menu::header'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['location' => 'header']); ?>
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
            <?php elseif(function_exists('pro_header_active') && pro_header_active('header')): ?>
                
                <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => 'tallcms-pro::full-header'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['location' => 'header']); ?>
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
            <?php else: ?>
                
                <div class="navbar bg-base-100 shadow-sm sticky top-0 z-50">
                    <div class="navbar-start">
                        <!-- Mobile Menu -->
                        <div class="dropdown lg:hidden">
                            <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                            </div>
                            <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow-lg bg-base-100 rounded-box w-52">
                                <?php if (isset($component)) { $__componentOriginal5893a4ae82cbde8a6e1ba16203c33ac0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5893a4ae82cbde8a6e1ba16203c33ac0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.menu','data' => ['location' => 'header','style' => 'vertical']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['location' => 'header','style' => 'vertical']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5893a4ae82cbde8a6e1ba16203c33ac0)): ?>
<?php $attributes = $__attributesOriginal5893a4ae82cbde8a6e1ba16203c33ac0; ?>
<?php unset($__attributesOriginal5893a4ae82cbde8a6e1ba16203c33ac0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5893a4ae82cbde8a6e1ba16203c33ac0)): ?>
<?php $component = $__componentOriginal5893a4ae82cbde8a6e1ba16203c33ac0; ?>
<?php unset($__componentOriginal5893a4ae82cbde8a6e1ba16203c33ac0); ?>
<?php endif; ?>
                            </ul>
                        </div>
                        <!-- Logo -->
                        <?php
                            $logo = \TallCms\Cms\Models\SiteSetting::get('logo');
                            $siteName = \TallCms\Cms\Models\SiteSetting::get('site_name', config('app.name'));
                        ?>
                        <a href="<?php echo e(tallcms_home_url()); ?>" class="btn btn-ghost text-xl font-bold">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($logo): ?>
                                <img src="<?php echo e(Storage::disk(cms_media_disk())->url($logo)); ?>"
                                     alt="<?php echo e($siteName); ?>"
                                     class="h-8 w-auto">
                            <?php else: ?>
                                <?php echo e($siteName); ?>

                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </a>
                    </div>

                    <!-- Desktop Menu -->
                    <div class="navbar-center hidden lg:flex">
                        <ul class="menu menu-horizontal px-1">
                            <?php if (isset($component)) { $__componentOriginal5893a4ae82cbde8a6e1ba16203c33ac0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5893a4ae82cbde8a6e1ba16203c33ac0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.menu','data' => ['location' => 'header','style' => 'horizontal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['location' => 'header','style' => 'horizontal']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5893a4ae82cbde8a6e1ba16203c33ac0)): ?>
<?php $attributes = $__attributesOriginal5893a4ae82cbde8a6e1ba16203c33ac0; ?>
<?php unset($__attributesOriginal5893a4ae82cbde8a6e1ba16203c33ac0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5893a4ae82cbde8a6e1ba16203c33ac0)): ?>
<?php $component = $__componentOriginal5893a4ae82cbde8a6e1ba16203c33ac0; ?>
<?php unset($__componentOriginal5893a4ae82cbde8a6e1ba16203c33ac0); ?>
<?php endif; ?>
                        </ul>
                    </div>

                    <div class="navbar-end gap-2">
                        <!-- Search -->
                        <?php echo $__env->make('theme.talldaisy::components.header-search', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                        <!-- Language Switcher -->
                        <?php echo $__env->make('theme.talldaisy::components.language-switcher', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                        <!-- Theme Switcher -->
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(supports_theme_controller()): ?>
                            <?php echo $__env->make('theme.talldaisy::components.theme-switcher', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showBreadcrumbs ?? false): ?>
                <?php if (isset($component)) { $__componentOriginal668d7ee94747b52127b7a413ec932bda = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal668d7ee94747b52127b7a413ec932bda = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tallcms::components.breadcrumbs','data' => ['items' => $breadcrumbItems ?? [],'overHero' => $breadcrumbsOverHero ?? false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallcms::breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($breadcrumbItems ?? []),'over-hero' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($breadcrumbsOverHero ?? false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal668d7ee94747b52127b7a413ec932bda)): ?>
<?php $attributes = $__attributesOriginal668d7ee94747b52127b7a413ec932bda; ?>
<?php unset($__attributesOriginal668d7ee94747b52127b7a413ec932bda); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal668d7ee94747b52127b7a413ec932bda)): ?>
<?php $component = $__componentOriginal668d7ee94747b52127b7a413ec932bda; ?>
<?php unset($__componentOriginal668d7ee94747b52127b7a413ec932bda); ?>
<?php endif; ?>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Main Content -->
            <main>
                <?php echo e($slot ?? ''); ?>

                <?php echo $__env->yieldContent('content'); ?>
            </main>

            <!-- Footer -->
            <footer class="footer footer-center bg-base-200 text-base-content p-10">
                <aside>
                    <?php
                        $logo = \TallCms\Cms\Models\SiteSetting::get('logo');
                        $siteName = \TallCms\Cms\Models\SiteSetting::get('site_name', config('app.name'));
                    ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($logo): ?>
                        <img src="<?php echo e(Storage::disk(cms_media_disk())->url($logo)); ?>"
                             alt="<?php echo e($siteName); ?>"
                             class="h-10 w-auto mb-2">
                    <?php else: ?>
                        <p class="font-bold text-lg"><?php echo e($siteName); ?></p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <p><?php echo e(\TallCms\Cms\Models\SiteSetting::get('site_tagline', 'A modern content management system built on the TALL stack.')); ?></p>
                </aside>

                
                <nav class="flex flex-wrap justify-center gap-2">
                    <?php $fbUrl = \TallCms\Cms\Models\SiteSetting::get('social_facebook'); ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($fbUrl): ?>
                        <a href="<?php echo e($fbUrl); ?>" target="_blank" rel="noopener" class="btn btn-ghost btn-circle" aria-label="Facebook">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" class="fill-current">
                                <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                            </svg>
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php $twUrl = \TallCms\Cms\Models\SiteSetting::get('social_twitter'); ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($twUrl): ?>
                        <a href="<?php echo e($twUrl); ?>" target="_blank" rel="noopener" class="btn btn-ghost btn-circle" aria-label="Twitter/X">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" class="fill-current">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php $igUrl = \TallCms\Cms\Models\SiteSetting::get('social_instagram'); ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($igUrl): ?>
                        <a href="<?php echo e($igUrl); ?>" target="_blank" rel="noopener" class="btn btn-ghost btn-circle" aria-label="Instagram">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" class="fill-current">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                            </svg>
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php $liUrl = \TallCms\Cms\Models\SiteSetting::get('social_linkedin'); ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($liUrl): ?>
                        <a href="<?php echo e($liUrl); ?>" target="_blank" rel="noopener" class="btn btn-ghost btn-circle" aria-label="LinkedIn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" class="fill-current">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php $ytUrl = \TallCms\Cms\Models\SiteSetting::get('social_youtube'); ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ytUrl): ?>
                        <a href="<?php echo e($ytUrl); ?>" target="_blank" rel="noopener" class="btn btn-ghost btn-circle" aria-label="YouTube">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" class="fill-current">
                                <path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php $ttUrl = \TallCms\Cms\Models\SiteSetting::get('social_tiktok'); ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ttUrl): ?>
                        <a href="<?php echo e($ttUrl); ?>" target="_blank" rel="noopener" class="btn btn-ghost btn-circle" aria-label="TikTok">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" class="fill-current">
                                <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                            </svg>
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php $nlUrl = \TallCms\Cms\Models\SiteSetting::get('newsletter_signup_url'); ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($nlUrl): ?>
                        <a href="<?php echo e($nlUrl); ?>" target="_blank" rel="noopener" class="btn btn-ghost btn-circle" aria-label="Newsletter">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" class="fill-current">
                                <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </nav>

                <nav>
                    <?php if (isset($component)) { $__componentOriginal5893a4ae82cbde8a6e1ba16203c33ac0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5893a4ae82cbde8a6e1ba16203c33ac0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.menu','data' => ['location' => 'footer','style' => 'footer']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['location' => 'footer','style' => 'footer']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5893a4ae82cbde8a6e1ba16203c33ac0)): ?>
<?php $attributes = $__attributesOriginal5893a4ae82cbde8a6e1ba16203c33ac0; ?>
<?php unset($__attributesOriginal5893a4ae82cbde8a6e1ba16203c33ac0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5893a4ae82cbde8a6e1ba16203c33ac0)): ?>
<?php $component = $__componentOriginal5893a4ae82cbde8a6e1ba16203c33ac0; ?>
<?php unset($__componentOriginal5893a4ae82cbde8a6e1ba16203c33ac0); ?>
<?php endif; ?>
                </nav>

                <aside>
                    <p>&copy; <?php echo e(date('Y')); ?> <?php echo e(\TallCms\Cms\Models\SiteSetting::get('site_name', config('app.name'))); ?>. All rights reserved.</p>
                    <?php if (isset($component)) { $__componentOriginal533228765084b3398330105faf9ad2e1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal533228765084b3398330105faf9ad2e1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tallcms::components.powered-by','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallcms::powered-by'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal533228765084b3398330105faf9ad2e1)): ?>
<?php $attributes = $__attributesOriginal533228765084b3398330105faf9ad2e1; ?>
<?php unset($__attributesOriginal533228765084b3398330105faf9ad2e1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal533228765084b3398330105faf9ad2e1)): ?>
<?php $component = $__componentOriginal533228765084b3398330105faf9ad2e1; ?>
<?php unset($__componentOriginal533228765084b3398330105faf9ad2e1); ?>
<?php endif; ?>
                </aside>
            </footer>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(supports_theme_controller()): ?>
        </div>

        <!-- Theme Drawer Sidebar -->
        <div class="drawer-side z-[60]">
            <label for="theme-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
            <div class="bg-base-200 min-h-full w-80 p-4">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold">Choose Theme</h2>
                    <label for="theme-drawer" class="btn btn-sm btn-circle btn-ghost">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </label>
                </div>
                <ul class="menu w-full p-0 gap-1" id="theme-list">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = daisyui_presets(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $preset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <button type="button"
                                    class="btn btn-sm btn-block btn-ghost justify-start theme-btn"
                                    data-theme-value="<?php echo e($preset); ?>">
                                <span class="badge badge-sm" data-theme="<?php echo e($preset); ?>">
                                    <span class="w-2 h-2 rounded-full bg-primary"></span>
                                    <span class="w-2 h-2 rounded-full bg-secondary"></span>
                                    <span class="w-2 h-2 rounded-full bg-accent"></span>
                                </span>
                                <?php echo e(ucfirst($preset)); ?>

                            </button>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <script>
        // Theme switcher - explicit control without relying on theme-controller class
        (function() {
            function setTheme(theme) {
                document.documentElement.setAttribute('data-theme', theme);
                localStorage.setItem('theme', theme);
                // Update active button styling
                document.querySelectorAll('.theme-btn').forEach(btn => {
                    btn.classList.toggle('btn-active', btn.dataset.themeValue === theme);
                });
                // Close the drawer after selection
                const drawer = document.getElementById('theme-drawer');
                if (drawer) drawer.checked = false;
            }

            function initThemeButtons() {
                const savedTheme = document.documentElement.getAttribute('data-theme');
                document.querySelectorAll('.theme-btn').forEach(btn => {
                    btn.classList.toggle('btn-active', btn.dataset.themeValue === savedTheme);
                    // Remove existing listener to avoid duplicates after navigation
                    btn.removeEventListener('click', btn._themeClickHandler);
                    btn._themeClickHandler = function() {
                        setTheme(this.dataset.themeValue);
                    };
                    btn.addEventListener('click', btn._themeClickHandler);
                });
            }

            // Initialize on page load
            initThemeButtons();

            // Navigation transitions
            document.addEventListener('livewire:navigate', function() {
                const bar = document.getElementById('nav-progress');
                const main = document.querySelector('main');
                if (bar) {
                    bar.classList.remove('done');
                    bar.classList.add('loading');
                }
                if (main) {
                    main.classList.add('page-transitioning');
                }
            });

            document.addEventListener('livewire:navigated', function() {
                const bar = document.getElementById('nav-progress');
                const main = document.querySelector('main');
                if (bar) {
                    bar.classList.remove('loading');
                    bar.classList.add('done');
                    setTimeout(() => bar.classList.remove('done'), 400);
                }
                if (main) {
                    main.classList.remove('page-transitioning');
                }
                // Re-apply theme: localStorage override or current data-theme (already set by boot script)
                var savedTheme = localStorage.getItem('theme');
                if (savedTheme) {
                    document.documentElement.setAttribute('data-theme', savedTheme);
                }
                initThemeButtons();
            });
        })();
    </script>

    
    <script>
        document.addEventListener('alpine:init', () => {
            if (window.__tallcmsPlugins?.length) {
                window.__tallcmsPlugins.forEach(plugin => window.Alpine.plugin(plugin));
                window.__tallcmsPlugins = []; // Clear to prevent double registration
            }
        });
    </script>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

    <?php if (isset($component)) { $__componentOriginal804566c8365d02f249b074a86f8bbb00 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal804566c8365d02f249b074a86f8bbb00 = $attributes; } ?>
<?php $component = TallCms\Cms\View\Components\CodeInjection::resolve(['zone' => 'body_end'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallcms::code-injection'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallCms\Cms\View\Components\CodeInjection::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal804566c8365d02f249b074a86f8bbb00)): ?>
<?php $attributes = $__attributesOriginal804566c8365d02f249b074a86f8bbb00; ?>
<?php unset($__attributesOriginal804566c8365d02f249b074a86f8bbb00); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal804566c8365d02f249b074a86f8bbb00)): ?>
<?php $component = $__componentOriginal804566c8365d02f249b074a86f8bbb00; ?>
<?php unset($__componentOriginal804566c8365d02f249b074a86f8bbb00); ?>
<?php endif; ?>
</body>
</html>
<?php /**PATH D:\WSERV\micrandria\themes\talldaisy/resources/views/layouts/app.blade.php ENDPATH**/ ?>