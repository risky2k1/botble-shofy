<?php

use Botble\Base\Forms\FieldOptions\LabelFieldOption;
use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\NumberFieldOption;
use Botble\Base\Forms\FieldOptions\OnOffFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\FieldOptions\UiSelectorFieldOption;
use Botble\Base\Forms\Fields\LabelField;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\NumberField;
use Botble\Base\Forms\Fields\OnOffField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\Fields\UiSelectorField;
use Botble\Newsletter\Forms\Fronts\NewsletterForm;
use Botble\Page\Models\Page;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\FieldOptions\ShortcodeTabsFieldOption;
use Botble\Shortcode\Forms\Fields\ShortcodeTabsField;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Facades\Theme;
use Carbon\Carbon;
use Illuminate\Support\Arr;

Shortcode::register('statistics-counter', __('Statistics Counter'), __('Statistics Counter'), function (ShortcodeCompiler $shortcode) {
    $tabCounterBoxs = Shortcode::fields()->getTabsData(['count_number', 'description'], $shortcode);

    return Theme::partial('shortcodes.statistics-counter.index', [
        'data' => $shortcode,
        'tabCounterBoxs' => $tabCounterBoxs,
    ]);
});

Shortcode::setAdminConfig('statistics-counter', function (array $attributes) {
    $styles = [];

    foreach (range(1, 1) as $i) {
        $styles[$i] = [
            'label' => __('Style :number', ['number' => $i]),
            'image' => Theme::asset()->url(sprintf('images/shortcodes/statistics-counter/style-%s.png', $i)),
        ];
    }

    return ShortcodeForm::createFromArray($attributes)
        ->withLazyLoading()
        ->add(
            'style',
            UiSelectorField::class,
            UiSelectorFieldOption::make()
                ->choices($styles)
                ->selected(Arr::get($attributes, 'style', 1))
        )
        ->add(
            'counter_box',
            ShortcodeTabsField::class,
            ShortcodeTabsFieldOption::make()
                ->fields([
                    'count_number' => [
                        'type' => 'number',
                        'title' => __('Count number'),
                    ],
                    'description' => [
                        'type' => 'text',
                        'title' => __('Description'),
                    ],
                ])
                ->attrs($attributes)
                ->max(4)

        );
});
