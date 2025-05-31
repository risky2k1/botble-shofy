<?php

namespace Botble\PageBuilder\Providers;

use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Base\Facades\DashboardMenu;
use Botble\PageBuilder\Models\PageBuilder;

class PageBuilderServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/page-builder')
            ->loadHelpers()
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishTranslations()
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadMigrations();

            if (defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME')) {
                \Botble\LanguageAdvanced\Supports\LanguageAdvancedManager::registerModule(PageBuilder::class, [
                    'name',
                ]);
            }

            // DashboardMenu::default()->beforeRetrieving(function () {
            //     DashboardMenu::registerItem([
            //         'id' => 'cms-plugins-page-builder',
            //         'priority' => 5,
            //         'parent_id' => null,
            //         'name' => 'plugins/page-builder::page-builder.name',
            //         'icon' => 'ti ti-box',
            //         'url' => route('page-builder.index'),
            //         'permissions' => ['page-builder.index'],
            //     ]);
            // });
    }
}
