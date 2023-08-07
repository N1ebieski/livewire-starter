<?php

declare(strict_types=1);

namespace App\Scopes\User;

use App\Models\User\User;
use App\Scopes\HasFilterableScopes;
use Illuminate\Contracts\Database\Eloquent\Builder;

/**
 * @mixin User
 */
trait HasUserScopes
{
    use HasFilterableScopes;

    public function scopeFilterStatusEmail(Builder $builder, ?bool $status = null): Builder
    {
        return $builder->when(!is_null($status), function (Builder $builder) use ($status) {
            return $builder->when($status === true, function (Builder $builder) {
                return $builder->whereNotNull('email_verified_at');
            }, function (Builder $builder) {
                return $builder->whereNull('email_verified_at');
            });
        });
    }
}
