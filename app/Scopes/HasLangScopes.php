<?php

declare(strict_types=1);

namespace App\Scopes;

use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;

/**
 * @mixin Model
 */
trait HasLangScopes
{
    public function scopeLang(Builder $builder): Builder
    {
        return $builder->where("{$this->getTable()}.lang", Config::get('app.locale'));
    }
}
