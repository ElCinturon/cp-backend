<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\BaseUser;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends BaseUser
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'username',
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
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function portfolios(): HasMany
    {
        return $this->hasMany(Portfolio::class);
    }

    public function offsetUnset(mixed $offset): void
    {
    }

    public function escapeWhenCastingToString($escape = true)
    {
    }

    public function offsetGet(mixed $offset): mixed
    {
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
    }
}
