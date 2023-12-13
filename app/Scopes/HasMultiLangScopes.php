<?php

declare(strict_types=1);

namespace App\Scopes;

use App\ValueObjects\AutoTranslate;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Contracts\Database\Eloquent\Builder;

/**
 * @mixin Model
 */
trait HasMultiLangScopes
{
    public function scopeMultiLang(Builder $query): Builder
    {
        /** @var Model */
        $lang = $this->langs()->make();

        return $query->join($lang->getTable(), function (JoinClause $join) use ($lang) {
            $className = mb_strtolower(class_basename($this::class));

            return $join->on("{$this->getTable()}.{$this->getKeyName()}", '=', "{$lang->getTable()}.{$className}_id")
                ->where("{$lang->getTable()}.lang", Config::get('app.locale'));
        })
        ->with('langs');
    }

    public function scopeAutoTrans(Builder $query): Builder
    {
        return $query->where('auto_translate', AutoTranslate::ACTIVE->value);
    }
}
