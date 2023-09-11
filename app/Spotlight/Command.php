<?php

declare(strict_types=1);

namespace App\Spotlight;

use Illuminate\Contracts\Auth\Access\Gate;
use LivewireUI\Spotlight\SpotlightCommand;
use App\Extends\Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Guard as BaseGuard;

/**
 * @property-read Guard $guard
 */
abstract class Command extends SpotlightCommand
{
    protected bool $default = false;

    public function __construct(
        protected Gate $gate,
        protected BaseGuard $guard,
    ) {
    }

    public function getDefault(): bool
    {
        return $this->default;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'synonyms' => $this->getSynonyms(),
            'dependencies' => $this->dependencies()?->toArray() ?? [],
            'default' => $this->getDefault()
        ];
    }
}
