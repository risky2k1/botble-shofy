<?php

use Botble\Base\Forms\FieldOptions\ColorFieldOption;
use Botble\Base\Forms\FieldOptions\CoreIconFieldOption;
use Botble\Base\Forms\FieldOptions\EditorFieldOption;
use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\OnOffFieldOption;
use Botble\Base\Forms\FieldOptions\RadioFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\FieldOptions\UiSelectorFieldOption;
use Botble\Base\Forms\Fields\ColorField;
use Botble\Base\Forms\Fields\CoreIconField;
use Botble\Base\Forms\Fields\EditorField;
use Botble\Base\Forms\Fields\HtmlField;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\OnOffField;
use Botble\Base\Forms\Fields\RadioField;
use Botble\Base\Forms\Fields\SelectField;
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

app()->booted(function (): void {
    ThemeSupport::registerGoogleMapsShortcode(Theme::getThemeNamespace('partials.shortcodes.google-maps'));
    ThemeSupport::registerYoutubeShortcode();

    Shortcode::register('site-features', __('Site Features'), __('Site Features'), function (ShortcodeCompiler $shortcode) {
        $tabs = Shortcode::fields()->getTabsData(['title', 'description', 'icon'], $shortcode);

        return Theme::partial('shortcodes.site-features.index', compact('shortcode', 'tabs'));
    });

    Shortcode::setPreviewImage('site-features', Theme::asset()->url('images/shortcodes/site-features/style-1.png'));

    Shortcode::setAdminConfig('site-features', function (array $attributes) {
        $styles = [];

        foreach (range(1, 4) as $i) {
            $styles[$i] = [
                'label' => __('Style :number', ['number' => $i]),
                'image' => Theme::asset()->url(sprintf('images/shortcodes/site-features/style-%s.png', $i)),
            ];
        }

        return ShortcodeForm::createFromArray($attributes)
            ->add(
                'style',
                UiSelectorField::class,
                UiSelectorFieldOption::make()
                    ->choices($styles)
                    ->selected(Arr::get($attributes, 'style', 1))
            )
            ->add(
                'features',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->fields([
                        'title'       => [
                            'type'     => 'text',
                            'title'    => __('Title'),
                            'required' => true,
                        ],
                        'image'       => [
                            'type'     => 'image',
                            'title'    => __('Image'),
                            'required' => true,
                        ],
                        'description' => [
                            'type'     => 'textarea',
                            'title'    => __('Description'),
                            'required' => false,
                        ],
                        'icon'        => [
                            'type'     => 'coreIcon',
                            'title'    => __('Icon'),
                            'required' => true,
                        ],
                    ])
                    ->attrs($attributes)
            )
            ->add(
                'icon_color',
                ColorField::class,
                ColorFieldOption::make()
                    ->label(__('Icon color'))
                    ->defaultValue('#fd4b6b')
            );
    });

    Shortcode::register('app-downloads', __('App Downloads'), __('App Downloads'), function (ShortcodeCompiler $shortcode): ?string {
        $platforms = Shortcode::fields()->getTabsData(['image', 'url'], $shortcode);

        return Theme::partial('shortcodes.app-downloads.index', compact('shortcode', 'platforms'));
    });

    Shortcode::setPreviewImage('app-downloads', Theme::asset()->url('images/shortcodes/app-downloads.png'));

    Shortcode::setAdminConfig('app-downloads', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->add(
                'title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Title'))
            )
            ->add(
                'open_wrapper_google',
                HtmlField::class,
                ['html' => '<div class="form-fieldset">']
            )
            ->add(
                'google_label',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Google label'))
                    ->placeholder(__('Enter Google label'))
            )
            ->add(
                'google_icon',
                CoreIconField::class,
                CoreIconFieldOption::make()
                    ->label(__('Google Play icon'))
            )
            ->add(
                'google_url',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Google URL'))
                    ->placeholder(__('Enter Google URL'))
            )
            ->add('close_wrapper_google', HtmlField::class, ['html' => '</div>'])
            ->add('open_wrapper_apple', HtmlField::class, ['html' => '<div class="form-fieldset">'])
            ->add(
                'apple_label',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Apple label'))
                    ->placeholder(__('Enter Apple label'))
            )
            ->add(
                'apple_icon',
                CoreIconField::class,
                CoreIconFieldOption::make()
                    ->label(__('Apple icon'))
            )
            ->add(
                'apple_url',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Apple URL'))
                    ->placeholder(__('Enter Apple URL'))
            )
            ->add('close_wrapper_apple', HtmlField::class, ['html' => '</div>'])
            ->add(
                'screenshot',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Mobile screenshot'))
            )
            ->add(
                'shape_image_left',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Shape image left'))
            )
            ->add(
                'shape_image_right',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Shape image right'))
            );
    });

    Shortcode::register(
        'image-slider',
        __('Image Slider'),
        __('Dynamic carousel for featured content with customizable links.'),
        function (ShortcodeCompiler $shortcode) {
            $tabs   = [];
            $brands = [];

            switch ($shortcode->type) {
                case 'custom':
                    $tabs = Shortcode::fields()->getTabsData(['name', 'image', 'url'], $shortcode);

                    if (empty($tabs)) {
                        return null;
                    }

                    break;

                case 'brands':
                    $brandIds = Shortcode::fields()->getIds('brand_ids', $shortcode);

                    if (empty($brandIds)) {
                        return null;
                    }

                    $brands = Brand::query()
                        ->wherePublished()
                        ->whereIn('id', $brandIds)
                        ->get();

                    if (empty($brands)) {
                        return null;
                    }

                    break;
            }

            return Theme::partial('shortcodes.image-slider.index', compact('shortcode', 'tabs', 'brands'));
        }
    );

    Shortcode::setPreviewImage('image-slider', Theme::asset()->url('images/shortcodes/image-slider.png'));

    Shortcode::setAdminConfig('image-slider', function (array $attributes) {
        $types = [
            'custom' => __('Custom'),
        ];

        if (is_plugin_active('ecommerce')) {
            $types['brands'] = __('Brands');
        }

        return ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->add(
                'type',
                RadioField::class,
                RadioFieldOption::make()
                    ->label(__('Get data from to show'))
                    ->choices($types)
                    ->attributes([
                        'data-bb-toggle' => 'collapse',
                        'data-bb-target' => '.image-slider',
                    ]),
            )
            ->when(is_plugin_active('ecommerce'), function (ShortcodeForm $form) use ($attributes): void {
                $form->add(
                    'brand_ids',
                    SelectField::class,
                    SelectFieldOption::make()
                        ->label(__('Brands'))
                        ->choices(
                            Brand::query()
                                ->wherePublished()
                                ->pluck('name', 'id')
                                ->all()
                        )
                        ->selected(ShortcodeField::parseIds(Arr::get($attributes, 'brand_ids')))
                        ->searchable()
                        ->multiple()
                        ->wrapperAttributes([
                            'class'         => 'mb-3 position-relative image-slider',
                            'data-bb-value' => 'brands',
                            'style'         => sprintf('display: %s', Arr::get($attributes, 'type') === 'brands' ? 'block' : 'none'),
                        ]),
                );
            })
            ->add(
                'open_tabs_wrapper',
                HtmlField::class,
                ['html' => sprintf('<div class="image-slider" data-bb-value="custom" style="display: %s">', Arr::get($attributes, 'type') === 'custom' ? 'block' : 'none')]
            )
            ->add(
                'tabs',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->fields([
                        'name'  => [
                            'type'  => 'text',
                            'title' => __('Name'),
                        ],
                        'image' => [
                            'type'     => 'image',
                            'title'    => __('Image'),
                            'required' => true,
                        ],
                        'url'   => [
                            'type'  => 'text',
                            'title' => __('URL'),
                        ],
                    ])
                    ->attrs($attributes)
            )
            ->add('close_tabs_wrapper', HtmlField::class, ['html' => '</div>']);
    });

    Shortcode::register('coming-soon', __('Coming Soon'), __('Coming Soon'), function (ShortcodeCompiler $shortcode): string {
        try {
            $countdownTime = Carbon::parse($shortcode->countdown_time);
        } catch (Exception) {
            $countdownTime = null;
        }

        $form = null;

        if (is_plugin_active('newsletter')) {
            $form = NewsletterForm::create();
        }

        return Theme::partial('shortcodes.coming-soon.index', compact('shortcode', 'countdownTime', 'form'));
    });

    Shortcode::setAdminConfig('coming-soon', function (array $attributes): ShortcodeForm {
        return ShortcodeForm::createFromArray($attributes)
            ->add(
                'title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Title'))
            )
            ->add(
                'countdown_time',
                'datetime',
                [
                    'label'         => __('Countdown time'),
                    'default_value' => Carbon::now()->addDays(7)->format('Y-m-d H:i'),
                ]
            )
            ->add(
                'address',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Address'))
            )
            ->add(
                'hotline',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Hotline'))
            )
            ->add(
                'business_hours',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Business hours'))
            )
            ->add(
                'show_social_links',
                OnOffField::class,
                OnOffFieldOption::make()
                    ->label(__('Show social links'))
                    ->defaultValue(true)
            )
            ->add(
                'image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Image'))
            );
    });

    Shortcode::register('table-of-contents', __('Table of Contents'), __('Table of Contents'), function (ShortcodeCompiler $shortcode): string {
        $tabs = Shortcode::fields()->getTabsData(['title', 'description'], $shortcode);
        return Theme::partial('shortcodes.table-of-contents.index', compact('shortcode', 'tabs'));
    });

    Shortcode::setAdminConfig('table-of-contents', function (array $attributes): ShortcodeForm {
        $styles    = [];
        $styles[0] = [
            'label' => __('List'),
            'image' => Theme::asset()->url('images/shortcodes/table-of-contents/style-list.png'),
        ];
        $styles['heading'] = [
            'label' => __('Heading'),
            'image' => Theme::asset()->url('images/shortcodes/table-of-contents/style-heading.png'),
        ];

        foreach (range(1, 5) as $i) {
            $styles[$i] = [
                'label' => __('Style :number', ['number' => $i]),
                'image' => Theme::asset()->url(sprintf('images/shortcodes/table-of-contents/style-%s.png', $i)),
            ];
        }
        return ShortcodeForm::createFromArray($attributes)
            ->columns(2)
            ->add(
                'style',
                UiSelectorField::class,
                UiSelectorFieldOption::make()
                    ->choices($styles)
                    ->selected(Arr::get($attributes, 'style', 0))
                    ->colspan(2)
            )
            ->add(
                'subtitle_left',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Subtitle left'))
                    ->colspan(1)
            )
            ->add(
                'subtitle_right',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Subtitle right'))
                    ->colspan(1)
            )
            ->add(
                'subtitle_left_2',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Subtitle left') . ' 2')
                    ->colspan(1)
            )
            ->add(
                'subtitle_right_2',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Subtitle right') . ' 2')
                    ->colspan(1)
            )
            ->add(
                'title_left',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Title left'))
                    ->colspan(1)
            )
            ->add(
                'title_right',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Title right'))
                    ->colspan(1)
            )
            ->add(
                'description_left',
                EditorField::class,
                EditorFieldOption::make()
                    ->label(__('Description left'))
                    ->colspan(2)
            )
            ->add(
                'description_right',
                EditorField::class,
                EditorFieldOption::make()
                    ->label(__('Description right'))
                    ->colspan(2)
            )
            ->add('image_left', MediaImageField::class, MediaImageFieldOption::make()->label(__('Image')))
            ->add('image_right', MediaImageField::class, MediaImageFieldOption::make()->label(__('Image')))
        // ->add(
        //     'features',
        //     ShortcodeTabsField::class,
        //     ShortcodeTabsFieldOption::make()
        //         ->fields([
        //             'image'       => [
        //                 'type'  => 'image',
        //                 'title' => __('Image'),
        //             ],
        //             'title'       => [
        //                 'type'  => 'text',
        //                 'title' => __('Title'),
        //             ],
        //             'description' => [
        //                 'type'  => 'text',
        //                 'title' => __('Description'),
        //             ],
        //         ])
        //         ->attrs($attributes)
        //         ->colspan(2)
        //         ->max(6)
        // )
            ->add(
                'text_color',
                ColorField::class,
                ColorFieldOption::make()
                    ->label(__('Text color'))
                    ->defaultValue('#ffffff')
            )
            ->add(
                'background_color',
                ColorField::class,
                ColorFieldOption::make()
                    ->label(__('Background color'))
                    ->defaultValue('#347c95')
            )
        ;
    });

    Shortcode::register('text', __('Text'), __('Text'), function (ShortcodeCompiler $shortcode): string {
        return Theme::partial('shortcodes.text.index', compact('shortcode'));
    });

    Shortcode::setAdminConfig('text', function (array $attributes): ShortcodeForm {
        return ShortcodeForm::createFromArray($attributes)
            ->add(
                'text',
                EditorField::class,
                EditorFieldOption::make()
                    ->label(__('Content'))
            );
    });

    Shortcode::register('life_cycle', __('Life Cycle'), __('Life Cycle'), function (ShortcodeCompiler $shortcode): string {
        $tabs = Shortcode::fields()->getTabsData(['title', 'description', 'color'], $shortcode);
        return Theme::partial('shortcodes.life_cycle.index', compact('shortcode', 'tabs'));
    });

    Shortcode::setAdminConfig('life_cycle', function (array $attributes): ShortcodeForm {
        return ShortcodeForm::createFromArray($attributes)
            ->add('title', TextField::class, TextFieldOption::make()->label(__('Title')))
            ->add(
                'features',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->fields([
                        'title'       => [
                            'type'  => 'text',
                            'title' => __('Title'),
                        ],
                        'description' => [
                            'type'  => 'textarea',
                            'title' => __('Description'),
                        ],
                        'color'      => [
                            'type'  => 'color',
                            'title' => __('Color'),
                            'value' => '#fd4b6b',
                        ],
                    ])
                    ->attrs($attributes)
                    ->colspan(2)
                    ->max(10)
            )
            ->add('image', MediaImageField::class, MediaImageFieldOption::make()->label(__('Image')))
            ->add('color', ColorField::class, ColorFieldOption::make()->label(__('Color'))->defaultValue('#ffffff'));
    });

    Shortcode::register('multiple_custom_columns', __('Multiple Custom Columns'), __('Multiple Custom Columns'), function (ShortcodeCompiler $shortcode): string {
        $tabs = Shortcode::fields()->getTabsData(['image', 'title', 'subtitle', 'description', 'action_label', 'action_url'], $shortcode);
        return Theme::partial('shortcodes.multiple-custom-columns.index', compact('shortcode', 'tabs'));
    });

    Shortcode::setAdminConfig('multiple_custom_columns', function (array $attributes): ShortcodeForm {
        $styles = [];
        foreach (range(1, 2) as $i) {
            $styles[$i] = [
                'label' => __('Style :number', ['number' => $i]),
                'image' => Theme::asset()->url(sprintf('images/shortcodes/multiple-custom-columns/style-%s.png', $i)),
            ];
        }
        return ShortcodeForm::createFromArray($attributes)
            ->add(
                'style',
                UiSelectorField::class,
                UiSelectorFieldOption::make()
                    ->choices($styles)
                    ->selected(Arr::get($attributes, 'style', 1))
                    ->colspan(2)
            )
            ->add('title', TextField::class, TextFieldOption::make()->label(__('Title')))
            ->add(
                'features',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->fields([
                        'image'        => [
                            'type'  => 'image',
                            'title' => __('Image'),
                        ],
                        'title'        => [
                            'type'  => 'text',
                            'title' => __('Title'),
                        ],
                        'subtitle'     => [
                            'type'  => 'text',
                            'title' => __('Subtitle'),
                        ],
                        'description'  => [
                            'type'  => 'textarea',
                            'title' => __('Description'),
                        ],
                        'action_label' => [
                            'type'  => 'text',
                            'title' => __('Action label'),
                        ],
                        'action_url'   => [
                            'type'  => 'text',
                            'title' => __('Action URL'),
                        ],
                    ])
                    ->attrs($attributes)
                    ->colspan(2)
                    ->max(12)
            )
            ->add('color', ColorField::class, ColorFieldOption::make()->label(__('Color'))->defaultValue('#ffffff'));
    });

    Shortcode::register('custom_column', __('Custom Column'), __('Custom Column'), function (ShortcodeCompiler $shortcode): string {
        return Theme::partial('shortcodes.custom-column.index', compact('shortcode'));
    });

    Shortcode::setAdminConfig('custom_column', function (array $attributes): ShortcodeForm {
        $styles = [];
        foreach (range(1, 2) as $i) {
            $styles[$i] = [
                'label' => __('Style :number', ['number' => $i]),
                'image' => Theme::asset()->url(sprintf('images/shortcodes/custom-column/style-%s.png', $i)),
            ];
        }
        return ShortcodeForm::createFromArray($attributes)
            ->add(
                'style',
                UiSelectorField::class,
                UiSelectorFieldOption::make()
                    ->choices($styles)
                    ->selected(Arr::get($attributes, 'style', 1))
                    ->colspan(2)
            )
            ->add('image', MediaImageField::class, MediaImageFieldOption::make()->label(__('Image')))
            ->add('title', TextField::class, TextFieldOption::make()->label(__('Title')))
            ->add(
                'subtitle',
                TextField::class,
                TextFieldOption::make()->label(__('Subtitle'))
            )
            ->add(
                'description_editor',
                EditorField::class,
                EditorFieldOption::make()->label(__('Description'))
            )
            ->add(
                'action_label',
                TextField::class,
                TextFieldOption::make()->label(__('Action label'))
            )
            ->add(
                'action_url',
                TextField::class,
                TextFieldOption::make()->label(__('Action URL'))
            );
    });
});
