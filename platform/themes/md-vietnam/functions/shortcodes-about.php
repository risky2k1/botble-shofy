<?php

use Botble\Base\Forms\FieldOptions\ColorFieldOption;
use Botble\Base\Forms\FieldOptions\CoreIconFieldOption;
use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\OnOffFieldOption;
use Botble\Base\Forms\FieldOptions\RadioFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\FieldOptions\UiSelectorFieldOption;
use Botble\Base\Forms\Fields\ColorField;
use Botble\Base\Forms\Fields\CoreIconField;
use Botble\Base\Forms\Fields\HtmlField;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\OnOffField;
use Botble\Base\Forms\Fields\RadioField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\Fields\UiSelectorField;
use Botble\Ecommerce\Models\Brand;
use Botble\Newsletter\Forms\Fronts\NewsletterForm;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\FieldOptions\ShortcodeTabsFieldOption;
use Botble\Shortcode\Forms\Fields\ShortcodeTabsField;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Shortcode\ShortcodeField;
use Botble\Theme\Facades\Theme;
use Botble\Theme\Supports\ThemeSupport;
use Carbon\Carbon;
use Illuminate\Support\Arr;

Shortcode::register('about', __('About'), __('About'), function (ShortcodeCompiler $shortcode) {
    $tabFeatureBoxs = Shortcode::fields()->getTabsData(['ft_image', 'ft_title', 'ft_description'], $shortcode);

    return Theme::partial('shortcodes.about.index', compact('shortcode', 'tabFeatureBoxs'));
});

Shortcode::setPreviewImage('about', Theme::asset()->url('images/shortcodes/about/style-1.png'));

Shortcode::setAdminConfig('about', function (array $attributes) {
    $styles = [];

    foreach (range(1, 3) as $i) {
        $styles[$i] = [
            'label' => __('Style :number', ['number' => $i]),
            'image' => Theme::asset()->url(sprintf('images/shortcodes/about/style-%s.png', $i)),
        ];
    }

    return ShortcodeForm::createFromArray($attributes)
        ->withLazyLoading()
        ->columns()
        ->add(
            'style',
            UiSelectorField::class,
            UiSelectorFieldOption::make()
                ->choices($styles)
                ->selected(Arr::get($attributes, 'style', 1))
                ->colspan(2)
        )
        ->add(
            'image_1',
            MediaImageField::class,
            MediaImageFieldOption::make()
                ->label(__('Image 1'))
        )
        ->add(
            'image_2',
            MediaImageField::class,
            MediaImageFieldOption::make()
                ->label(__('Image 2'))
        )
        ->add(
            'subtitle',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Subtitle'))
                ->colspan(1)
        )
        ->add(
            'subtitle_2',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Subtitle') . ' 2')
                ->colspan(1)
        )
        ->add(
            'title',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Title'))
                ->colspan(2)
        )
        ->add(
            'description',
            TextareaField::class,
            TextareaFieldOption::make()
                ->label(__('Description'))
                ->colspan(2)
        )
        ->add(
            'feature_box',
            ShortcodeTabsField::class,
            ShortcodeTabsFieldOption::make()
                ->fields([
                    'ft_image' => [
                        'type' => 'image',
                        'title' => __('Image'),
                    ],
                    'ft_title' => [
                        'type' => 'text',
                        'title' => __('Title'),
                    ],
                    'ft_description' => [
                        'type' => 'text',
                        'title' => __('Description'),
                    ],
                ])
                ->attrs($attributes)
                ->colspan(2)
                ->max(2)

        )
        ->add(
            'action_label',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Action label')),
        )
        ->add(
            'action_url',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Action URL')),
        )
        ->add(
            'youtube_iframe',
            TextareaField::class,
            TextareaFieldOption::make()
                ->label(__('YouTube Iframe'))
                ->colspan(2)
        )
        ->add(
            'description_2',
            TextareaField::class,
            TextareaFieldOption::make()
                ->label(__('Description') . ' 2')
                ->colspan(2)
        );
});
