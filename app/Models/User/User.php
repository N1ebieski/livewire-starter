<?php

declare(strict_types=1);

namespace App\Models\User;

use Laravel\Sanctum\HasApiTokens;
use App\Scopes\User\HasUserScopes;
use Spatie\Permission\Traits\HasRoles;
use Database\Factories\User\UserFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail, Authorizable
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
}
