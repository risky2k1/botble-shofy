<?php

use Botble\Base\Forms\FieldOptions\LabelFieldOption;
use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\NumberFieldOption;
use Botble\Base\Forms\FieldOptions\OnOffFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\LabelField;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\NumberField;
use Botble\Base\Forms\Fields\OnOffField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Newsletter\Forms\Fronts\NewsletterForm;
use Botble\Page\Models\Page;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\FieldOptions\ShortcodeTabsFieldOption;
use Botble\Shortcode\Forms\Fields\ShortcodeTabsField;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Facades\Theme;
use Carbon\Carbon;

app()->booted(function (): void {
    //////////// Block 5 ///////////////
    function block5()
    {
        Shortcode::register('block-5', __('Home Block 5'), __('Home Block 5'), function (ShortcodeCompiler $shortcode) {
            $listEqualRights = Shortcode::fields()->getTabsData(['image', 'title', 'description', 'link'], $shortcode);

            return Theme::partial('shortcodes.home.block-5', [
                'listEqualRights' => $listEqualRights,
                'data' => $shortcode,
            ]);
        });

        Shortcode::setAdminConfig('block-5', function (array $attributes) {
            return ShortcodeForm::createFromArray($attributes)
                ->withLazyLoading()
                ->add(
                    'background_image',
                    MediaImageField::class,
                    MediaImageFieldOption::make()
                        ->label(__('Background Image'))
                )
                ->add(
                    'image_left',
                    MediaImageField::class,
                    MediaImageFieldOption::make()
                        ->label(__('Image Left'))
                )
                ->add(
                    'link_left',
                    TextField::class,
                    TextFieldOption::make()
                        ->label(__('Link Left'))
                )
                ->add(
                    'title',
                    TextField::class,
                    TextFieldOption::make()
                        ->label(__('Title'))
                )
                ->add(
                    'list_equal_right',
                    ShortcodeTabsField::class,
                    ShortcodeTabsFieldOption::make()
                        ->fields([
                            'image' => [
                                'type' => 'image',
                                'title' => __('Image'),
                            ],
                            'title' => [
                                'type' => 'text',
                                'title' => __('Title'),
                            ],
                            'description' => [
                                'type' => 'text',
                                'title' => __('Description'),
                            ],
                            'link' => [
                                'type' => 'text',
                                'title' => __('Link'),
                            ],
                        ])
                        ->attrs($attributes)
                        ->max(8)
                )
                ////// Left //////
                ->add(
                    'title_bottom_left',
                    TextField::class,
                    TextFieldOption::make()
                        ->label(__('Title Bottom Left'))
                )
                ->add(
                    'image_bottom_left_1',
                    MediaImageField::class,
                    MediaImageFieldOption::make()
                        ->label(__('Image Bottom Left 1'))
                )
                ->add(
                    'description_bottom_left_1',
                    TextField::class,
                    TextFieldOption::make()
                        ->label(__('Description Bottom Left 1'))
                )

                ->add(
                    'image_bottom_left_2',
                    MediaImageField::class,
                    MediaImageFieldOption::make()
                        ->label(__('Image Bottom Left 2'))
                )
                ->add(
                    'description_bottom_left_2',
                    TextField::class,
                    TextFieldOption::make()
                        ->label(__('Description Bottom Left 2'))
                )
                ////// Right //////
                ->add(
                    'title_bottom_right',
                    TextField::class,
                    TextFieldOption::make()
                        ->label(__('Title Bottom Right'))
                )
                ->add(
                    'image_bottom_right',
                    MediaImageField::class,
                    MediaImageFieldOption::make()
                        ->label(__('Image Bottom Right'))
                );
        });
    }

    // Initialize the blocks
    $blocks = [
        // 'block1',
        // 'block2',
        // 'block3',
        // 'block4',
        'block5',
        // 'block6',
        // 'block7',
    ];

    foreach ($blocks as $block) {
        if (function_exists($block)) {
            $block();
        }
    }
});
