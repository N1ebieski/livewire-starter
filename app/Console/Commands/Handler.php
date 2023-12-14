<?php

declare(strict_types=1);

namespace App\Console\Commands;

use AllowDynamicProperties;
use App\Console\Forms\Form;
use Illuminate\Console\Command as BaseCommand;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

/**
 * @property-read Form $form
 */
#[AllowDynamicProperties]
abstract class Handler extends BaseCommand
{
    public function __construct(
        protected ValidationFactory $validationFactory,
    ) {
        parent::__construct();

        if (property_exists($this, 'form')) {
            $this->form->setCommand($this);
        }
    }

    protected function validateOnly(string $key, mixed $value): string
    {
        $validator = $this->validationFactory->make(
            [$key => $value],
            [$key => $this->form->rules()[$key]]
        );

        $errors = $validator->errors()->getMessages();

        return $errors[$key][0] ?? '';
    }
}
