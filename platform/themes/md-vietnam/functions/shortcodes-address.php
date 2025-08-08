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

Shortcode::register('adrress', __('Address'), __('Address'), function (ShortcodeCompiler $shortcode) {
    $addressBoxes = Shortcode::fields()->getTabsData(['company_name', 'address', 'phone', 'email'], $shortcode);

    return Theme::partial('shortcodes.address.index', compact('shortcode', 'addressBoxes'));
});

Shortcode::setAdminConfig('adrress', function (array $attributes) {
    $styles = [];

    foreach (range(1, 1) as $i) {
        $styles[$i] = [
            'label' => __('Style :number', ['number' => $i]),
            'image' => Theme::asset()->url(sprintf('images/shortcodes/address/style-%s.png', $i)),
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
            'background_image',
            MediaImageField::class,
            MediaImageFieldOption::make()
                ->label(__('Background image'))
        )
        ->add(
            'title',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Title'))
        )
        ->add(
            'addess_box',
            ShortcodeTabsField::class,
            ShortcodeTabsFieldOption::make()
                ->fields([
                    'company_name' => [
                        'type' => 'text',
                        'title' => __('Company Name'),
                    ],
                    'address' => [
                        'type' => 'text',
                        'title' => __('Address'),
                    ],
                    'phone' => [
                        'type' => 'text',
                        'title' => __('Phone'),
                    ],
                    'email' => [
                        'type' => 'email',
                        'title' => __('Email'),
                    ],
                ])
                ->attrs($attributes)
                ->max(8)

        );
});
