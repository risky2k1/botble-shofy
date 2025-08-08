<?php

use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Shortcode\Forms\FieldOptions\ShortcodeTabsFieldOption;
use Botble\Shortcode\Forms\Fields\ShortcodeTabsField;
use Botble\Widget\AbstractWidget;
use Botble\Widget\Forms\WidgetForm;
use Illuminate\Support\Collection;

class FooterColsWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Footer Cols'),
            'description' => __('Display footer columns'),
        ]);
    }

    protected function settingForm(): WidgetForm | string | null
    {
        return WidgetForm::createFromArray($this->getConfig())
            ->add('title', TextField::class,
                TextFieldOption::make()
                    ->label(__('Title'))
                    ->placeholder(__('Enter Title')))
            ->add(
                'features',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->fields([
                        // 'title'       => [
                        //     'type'     => 'text',
                        //     'title'    => __('Title'),
                        //     'required' => true,
                        // ],
                        'description' => [
                            'type'     => 'textarea',
                            'title'    => __('Description'),
                            'required' => true,
                        ],
                        'icon'        => [
                            'type'     => 'coreIcon',
                            'title'    => __('Icon'),
                            'required' => false,
                        ],
                        'label'       => [
                            'type'     => 'text',
                            'title'    => __('Label'),
                            'required' => false,
                        ],
                        'url'       => [
                            'type'     => 'text',
                            'title'    => __('URL'),
                            'required' => false,
                        ],
                    ])->attrs($this->getConfig())
            );
    }

    protected function data(): array|Collection
    {
        $tabs = get_tabs_data(['description', 'icon', 'url', 'label'], $this->getConfig());

        return compact('tabs');
    }
}
