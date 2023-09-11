<?php

declare(strict_types=1);

namespace App\Models\User;

use Laravel\Sanctum\HasApiTokens;
use App\Scopes\User\HasUserScopes;
use App\ValueObjects\User\StatusEmail;
use Spatie\Permission\Traits\HasRoles;
use Database\Factories\User\UserFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\User\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read StatusEmail $status_email
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\User\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User filterExcept(?array $except = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User filterOrderBy(?\App\Queries\OrderBy $orderby = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User filterOrderBySearch(?\App\Queries\Search $search = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User filterPaginate(?\App\Queries\Paginate $paginate = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User filterRole(?\App\Models\Role\Role $role = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User filterSearch(?\App\Queries\Search $search = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User filterSearchAttributes(?\App\Queries\Search $search = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User filterStatusEmail(?bool $status = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User withAllRelations()
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|User filterGet(\App\Queries\Get $get)
 * @method static \Illuminate\Database\Eloquent\Builder|User filterResult(\App\Queries\Paginate|\App\Queries\Get|null $result = null)
 * @mixin \Eloquent
 */
final class User extends Authenticatable implements MustVerifyEmail, Authorizable
{
    use HasRoles;
    use HasUserScopes;
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * @var string
     */
    protected $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * The columns of the full text index
     */
    public array $searchable = ['name', 'email'];

    public array $searchableAttributes = ['id'];

    public array $sortable = ['id', 'name', 'email', 'email_verified_at', 'created_at', 'updated_at'];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }

    // Attributes

    public function statusEmail(): Attribute
    {
        return new Attribute(fn (): StatusEmail => !is_null($this->email_verified_at) ?
            StatusEmail::VERIFIED : StatusEmail::UNVERIFIED);
    }
}
