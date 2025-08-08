<?php

use Botble\Widget\Facades\Widget;
use Botble\Widget\Facades\WidgetGroup;
use Botble\Widget\Factories\WidgetFactory;
use Botble\Widget\WidgetGroupCollection;

if (! function_exists('register_widget')) {
    function register_widget(string $widgetId): WidgetFactory
    {
        return Widget::registerWidget($widgetId);
    }
}

if (! function_exists('register_sidebar')) {
    function register_sidebar(array $args): WidgetGroupCollection
    {
        return WidgetGroup::setGroup($args);
    }
}

if (! function_exists('remove_sidebar')) {
    function remove_sidebar(string $sidebarId): WidgetGroupCollection
    {
        return WidgetGroup::removeGroup($sidebarId);
    }
}

if (! function_exists('dynamic_sidebar')) {
    function dynamic_sidebar(string $sidebarId): string
    {
        return WidgetGroup::render($sidebarId);
    }
}

if (! function_exists('get_tabs_data')) {
    function get_tabs_data(array $fields, $shortcode): array
    {
        $quantity = $shortcode['quantity'] ?? 0;
        if (empty($shortcode) || empty($fields) || ! $quantity) {
            return [];
        }

        $tabs = [];

        for ($i = 1; $i <= $quantity; $i++) {
            $tab = [];
            foreach ($fields as $field) {
                if (isset($shortcode["{$field}_{$i}"])) {
                    $tab[$field] = $shortcode["{$field}_{$i}"];
                }
            }

            if (! empty(array_filter($tab, fn($field) => $field !== null && $field !== ''))) {
                $tabs[] = $tab;
            }
        }

        return $tabs;
    }
}
