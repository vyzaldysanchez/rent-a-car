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
 * @property int $employeeId
 * @property string $state
 */
class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'state'
    ];

    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at'
    ];

    public function scopeWhereEmail(Builder $query, string $email) : Builder
    {
        return $query->where('email', '=', $email);
    }

    public static function findByEmail(string $email) : ? User
    {
        return parent::where('email', '=', $email)->first();
    }

    public function activate() : User
    {
        $this->update(['state' => CommonStatus::ACTIVE]);
        return $this;
    }

    public function desactivate() : User
    {
        $this->update(['state' => CommonStatus::INACTIVE]);
        return $this;
    }
}
