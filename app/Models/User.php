<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Enums\CommonStatus;

/**
 * Class User
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $state
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'state'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at'
    ];

    public function scopeWhereEmail(Builder $query, string $email): Builder
    {
        return $query->where('email', '=', $email);
    }

    public static function findByEmail(): ?User
    {
        return parent::where('email', '=', $email)->first();
    }

    public function activate(): User
    {
        $this->update(['state' => CommonStatus::ACTIVE]);
        return $this;
    }

    public function desactivate(): User
    {
        $this->update(['state' => CommonStatus::INACTIVE]);
        return $this;
    }
}
