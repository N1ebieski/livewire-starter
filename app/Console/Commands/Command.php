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

    /**
     * @param array<string, string> $arguments
     */
    protected function askArguments(array $arguments): void
    {
        $validator = $this->validationFactory->make([], []);

        while (($arg = current($arguments)) !== false) {
            if ($this->hasArgument($arg)) {
                next($arguments);

                continue;
            }

            $value = $this->ask($arg);
            $key = key($arguments);

            if (array_key_exists($key, $this->rules())) {
                $validator = $this->validationFactory->make(
                    array_merge($this->argument(), [$key => $value]),
                    [$key => $this->rules()[$key]]
                );

                foreach ($validator->errors()->getMessages() as $arg => $error) {
                    $this->error($arg . ": " . $error[0] . "\n");
                }
            }

            if (!$validator->fails()) {
                $this->addArgument(
                    name: $key,
                    default: $value
                );

                next($arguments);
            } else {
                if (
                    array_key_exists($key, $this->rules())
                    && in_array('confirmed', $this->rules()[$key])
                ) {
                    prev($arguments);
                }
            }
        }
    }

    protected function rules(): array
    {
        return [];
    }
}
