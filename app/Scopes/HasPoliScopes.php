<?php

declare(strict_types=1);

namespace App\Scopes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;

/**
 * @mixin Model
 */
trait HasPoliScopes
{
    public function scopePoliType(Builder $query): Builder
    {
        return $query->where("{$this->getTable()}.model_type", $this->model_type);
    }

    public function scopePoli(Builder $query): Builder
    {
        //@phpstan-ignore-next-line
        return $query->poliType()->where("{$this->getTable()}.model_id", $this->model_id);
    }
}
