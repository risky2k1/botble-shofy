<?php

use Botble\Base\Forms\FieldOptions\CheckboxFieldOption;
use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\NumberFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\NumberField;
use Botble\Base\Forms\Fields\OnOffCheckboxField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Shortcode\Forms\FieldOptions\ShortcodeTabsFieldOption;
use Botble\Shortcode\Forms\Fields\ShortcodeTabsField;
use Botble\Theme\Facades\Theme;
use Botble\Widget\AbstractWidget;
use Botble\Widget\Forms\WidgetForm;

class SiteInfoWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name'              => __('Site information'),
            'description'       => __('Widget display site information'),
            'logo'              => null,
            'logo_height'       => 35,
            'about'             => null,
            'show_social_links' => true,
        ]);
    }

    protected function settingForm(): WidgetForm | string | null
    {
        return WidgetForm::createFromArray($this->getConfig())
            ->add(
                'logo',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Logo'))
                    ->defaultValue(Theme::getLogo())
                    ->helperText(__('Leave empty to use the default logo in Theme Options.'))
            )
            ->add(
                'logo_height',
                NumberField::class,
                NumberFieldOption::make()
                    ->label(__('Logo height (default: 35px)'))
                    ->defaultValue(35)
            )
            ->add('title', TextField::class,
                TextFieldOption::make()
                    ->label(__('Title'))
                    ->placeholder(__('Enter Title')))
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
                    ])->attrs($this->getConfig())
            )
            ->add(
                'about',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->label(__('About'))
            )
            ->add(
                'image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Image'))
            )
            ->add(
                'show_social_links',
                OnOffCheckboxField::class,
                CheckboxFieldOption::make()
                    ->label(__('Show social links'))
                    ->helperText(
                        __(
                            'Toggle to display or hide social links on your site. Configure the links in Theme Options -> Social Links.'
                        )
                    )
            );
    }

    public function data(): array
    {
        $height = $this->getConfig('logo_height') ?: theme_option('logo_height', 35);

        $attributes = [
            'style'   => sprintf('max-height: %s', is_numeric($height) ? "{$height}px" : $height),
            'loading' => 'lazy',
        ];
        $tabs = get_tabs_data(['title', 'description', 'icon'], $this->getConfig());

        return compact('attributes', 'tabs');
    }
}
