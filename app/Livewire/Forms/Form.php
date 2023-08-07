<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use Livewire\Component;
use Livewire\Form as BaseForm;

abstract class Form extends BaseForm
{
    protected array $messages = [];

    public function __construct(
        protected Component $component,
        protected $propertyName
    ) {
        $this->addValidationRulesToComponent();
        //Fix. Livewire doesn't have possibility to set validation messages from method
        $this->addValidationMessagesToComponent();
    }

    /**
     * Fix. Livewire doesn't have possibility to set validation messages from method
     */
    public function addValidationMessagesToComponent(): void
    {
        $messages = [];

        if (method_exists($this, 'messages')) {
            $messages = $this->messages();
        } elseif (property_exists($this, 'messages')) {
            $messages = $this->messages;
        }

        $messagesWithPrefixedKeys = [];

        foreach ($messages as $key => $value) {
            $messagesWithPrefixedKeys[$this->propertyName . '.' . $key] = $value;
        }

        $this->component->addMessagesFromOutside($messagesWithPrefixedKeys);
    }
}
