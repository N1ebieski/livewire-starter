<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Livewire\LivewireManager;
use Illuminate\Support\Facades\App;
use Mews\Purifier\Facades\Purifier;

final class XSSProtection
{
    /**
     * Tablica zawierajca klucze requestow ktore maja byc pomijane przy strip_tags,
     * zamiast tego wykonywany jest na nich clean przez HTML Purifier
     */
    protected array $except = ['content_html'];

    private function isLivewireRequest(): bool
    {
        if (class_exists(LivewireManager::class)) {
            /** @var LivewireManager */
            $livewireManager = App::make(LivewireManager::class);

            return $livewireManager->isLivewireRequest();
        }

        return false;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if ($this->isLivewireRequest()) {
            return $next($request);
        }

        $input = $request->all();

        array_walk_recursive($input, function (&$value, $key) {
            if (in_array($key, $this->except, true)) {
                $value = Purifier::clean($value);
            }

            if (is_string($value)) {
                $value = strip_tags($value);
            }
        });

        $request->merge($input);

        return $next($request);
    }
}
