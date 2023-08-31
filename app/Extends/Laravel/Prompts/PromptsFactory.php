<?php

declare(strict_types=1);

namespace App\Extends\Laravel\Prompts;

use Closure;
use Laravel\Prompts\Note;
use Laravel\Prompts\Spinner;
use Laravel\Prompts\TextPrompt;
use Laravel\Prompts\SearchPrompt;
use Laravel\Prompts\SelectPrompt;
use Illuminate\Support\Collection;
use Laravel\Prompts\ConfirmPrompt;
use Laravel\Prompts\SuggestPrompt;
use Laravel\Prompts\PasswordPrompt;
use Laravel\Prompts\MultiSelectPrompt;
use App\Extends\Laravel\Prompts\Contracts\Prompts;

final class PromptsFactory implements Prompts
{
    /**
     * Prompt the user for text input.
     */
    public function text(string $label, string $placeholder = '', string $default = '', bool|string $required = false, Closure $validate = null, string $hint = ''): string
    {
        return (new TextPrompt($label, $placeholder, $default, $required, $validate, $hint))->prompt();
    }

    /**
     * Prompt the user for input, hiding the value.
     */
    public function password(string $label, string $placeholder = '', bool|string $required = false, Closure $validate = null, string $hint = ''): string
    {
        return (new PasswordPrompt($label, $placeholder, $required, $validate, $hint))->prompt();
    }

    /**
     * Prompt the user to select an option.
     *
     * @param  array<int|string, string>|Collection<int|string, string>  $options
     */
    public function select(string $label, array|Collection $options, int|string $default = null, int $scroll = 5, Closure $validate = null, string $hint = ''): int|string
    {
        return (new SelectPrompt($label, $options, $default, $scroll, $validate, $hint))->prompt();
    }

    /**
     * Prompt the user to select multiple options.
     *
     * @param  array<int|string, string>|Collection<int|string, string>  $options
     * @param  array<int|string>|Collection<int, int|string>  $default
     * @return array<int|string>
     */
    public function multiselect(string $label, array|Collection $options, array|Collection $default = [], int $scroll = 5, bool|string $required = false, Closure $validate = null, string $hint = 'Use the space bar to select options.'): array
    {
        return (new MultiSelectPrompt($label, $options, $default, $scroll, $required, $validate, $hint))->prompt();
    }

    /**
     * Prompt the user to confirm an action.
     */
    public function confirm(string $label, bool $default = true, string $yes = 'Yes', string $no = 'No', bool|string $required = false, Closure $validate = null, string $hint = ''): bool
    {
        return (new ConfirmPrompt($label, $default, $yes, $no, $required, $validate, $hint))->prompt();
    }

    /**
     * Prompt the user for text input with auto-completion.
     *
     * @param  array<string>|Collection<int, string>|Closure(string): array<string>  $options
     */
    public function suggest(string $label, array|Collection|Closure $options, string $placeholder = '', string $default = '', int $scroll = 5, bool|string $required = false, Closure $validate = null, string $hint = ''): string
    {
        return (new SuggestPrompt($label, $options, $placeholder, $default, $scroll, $required, $validate, $hint))->prompt();
    }

    /**
     * Allow the user to search for an option.
     *
     * @param  Closure(string): array<int|string, string>  $options
     */
    public function search(string $label, Closure $options, string $placeholder = '', int $scroll = 5, Closure $validate = null, string $hint = ''): int|string
    {
        return (new SearchPrompt($label, $options, $placeholder, $scroll, $validate, $hint))->prompt();
    }

    /**
     * Render a spinner while the given callback is executing.
     *
     * @template TReturn of mixed
     *
     * @param  \Closure(): TReturn  $callback
     * @return TReturn
     */
    public function spin(Closure $callback, string $message = ''): mixed
    {
        return (new Spinner($message))->spin($callback);
    }

    /**
     * Display a note.
     */
    public function note(string $message, string $type = null): void
    {
        (new Note($message, $type))->display();
    }

    /**
     * Display an error.
     */
    public function error(string $message): void
    {
        (new Note($message, 'error'))->display();
    }

    /**
     * Display a warning.
     */
    public function warning(string $message): void
    {
        (new Note($message, 'warning'))->display();
    }

    /**
     * Display an alert.
     */
    public function alert(string $message): void
    {
        (new Note($message, 'alert'))->display();
    }

    /**
     * Display an informational message.
     */
    public function info(string $message): void
    {
        (new Note($message, 'info'))->display();
    }

    /**
     * Display an introduction.
     */
    public function intro(string $message): void
    {
        (new Note($message, 'intro'))->display();
    }

    /**
     * Display a closing message.
     */
    public function outro(string $message): void
    {
        (new Note($message, 'outro'))->display();
    }
}