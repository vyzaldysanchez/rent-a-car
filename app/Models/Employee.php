<?php

namespace App\Models;

use App\Models\Enums\CommonStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Concerns\QueriesRelationships;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Employee
 * @package App\Models
 *
 * @property int    $id
 * @property string $name
 * @property string $identification_card
 * @property string $work_schedule
 * @property float  $commission_percent
 * @property string $admission_date
 * @property string $state
 * @property string $created_at
 * @property string $updated_at
 * @property int    $user_id
 * @property User   $credentials
 * @property User $nonActiveCredentials
 */
class Employee extends User
{
    use HasRelationShips, QueriesRelationships;

    protected $id;
    protected $name;
    protected $identification_card;
    protected $work_schedule;
    protected $commission_percent;
    protected $admission_date;
    protected $state;
    protected $created_at;
    protected $updated_at;
    protected $user_id;

    protected $fillable = [
        'name',
        'identification_card',
        'work_schedule',
        'commission_percent',
        'admission_date',
        'user_id'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected static function boot(): void
    {
        parent::boot();

        static::deleting(function (Employee $employee) {
            $employee->user()->delete();
        });
    }

    protected function userAttatched(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->select(['id', 'email', 'state']);
    }


    public function credentials(): BelongsTo
    {
        return $this->userAttatched();
    }

    public function hasActiveCredentials(): bool
    {
        return optional($this->credentials)->state === CommonStatus::ACTIVE;
    }

    public function hasInactiveCredentials(): bool
    {
        return optional($this->credentials)->state === CommonStatus::INACTIVE;
    }

    public static function existsByIdentificationCard(string $identification): bool
    {
        return parent::where('identification_card', '=', $identification)->exists();
    }

    public static function allWithCredentials(): Collection
    {
        return parent::with(['credentials'])->get(['*']);
    }
}
