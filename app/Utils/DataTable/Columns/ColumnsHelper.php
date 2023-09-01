<?php

declare(strict_types=1);

namespace App\Utils\DataTable\Columns;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Contracts\Config\Repository as Config;

final class ColumnsHelper
{
    public function __construct(
        private Request $request,
        private Config $config,
        private Str $str
    ) {
    }

    public function getAlias(string $namespace): string
    {
        return $this->str->of($namespace)
            ->replace($this->config->get('livewire.class_namespace') . '\\', '')
            ->cookieAlias()
            ->append('_form_columns')
            ->toString();
    }

    public function doesUserHaveColumns(string $name): bool
    {
        return !empty($this->request->cookie($name));
    }
}
