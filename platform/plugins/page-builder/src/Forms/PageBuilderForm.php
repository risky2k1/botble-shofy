<?php

namespace Botble\PageBuilder\Forms;

use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\PageBuilder\Http\Requests\PageBuilderRequest;
use Botble\PageBuilder\Models\PageBuilder;

class PageBuilderForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(PageBuilder::class)
            ->setValidatorClass(PageBuilderRequest::class)
            ->add('name', TextField::class, NameFieldOption::make()->required())
            ->add('status', SelectField::class, StatusFieldOption::make())
            ->setBreakFieldPoint('status');
    }
}
