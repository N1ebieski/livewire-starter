<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command as BaseCommand;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

abstract class Command extends BaseCommand
{
    public function __construct(protected ValidationFactory $validationFactory)
    {
        parent::__construct();
    }

    protected function validateOnly(string $key, mixed $value): string
    {
        $validator = $this->validationFactory->make(
            [$key => $value],
            [$key => $this->rules()[$key]]
        );

        $errors = $validator->errors()->getMessages();

        return $errors[$key][0] ?? '';
    }

    protected function rules(): array
    {
        return [];
    }
}
