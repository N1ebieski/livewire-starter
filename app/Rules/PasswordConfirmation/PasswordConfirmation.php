<?php

declare(strict_types=1);

namespace App\Rules\PasswordConfirmation;

use Closure;
use Stringable;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Contracts\Validation\ValidationRule;

class PasswordConfirmation implements ValidationRule, Stringable
{
    public function __construct(
        private string $password,
        private Hasher $hasher,
        private Translator $translator
    ) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->passes($attribute, $value)) {
            $fail($this->translator->get('passwords.confirmation'));
        }
    }

    private function passes(string $attribute, mixed $value): bool
    {
        return $this->hasher->check($value, $this->password);
    }

    public function __toString(): string
    {
        return 'password_confirmation';
    }
}
