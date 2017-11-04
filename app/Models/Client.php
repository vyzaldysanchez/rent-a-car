<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Client
 * @package App\Models
 *
 * @property int    $id
 * @property string $name
 * @property string $identification_number
 * @property string $credit_card_number
 * @property float  $credit_limit
 * @property int    $person_type_id
 * @property string $state
 * @property string $created_at
 * @property string $updated_at
 */
class Client extends Model
{
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $identification_number;
    /**
     * @var string
     */
    protected $credit_card_number;
    /**
     * @var float
     */
    protected $credit_limit;
    /**
     * @var int
     */
    protected $person_type_id;
    /**
     * @var string
     */
    protected $state;
    /**
     * @var string
     */
    protected $created_at;
    /**
     * @var string
     */
    protected $updated_at;

    protected $fillable = [
        'name',
        'identification_number',
        'credit_card_number',
        'credit_limit',
        'state',
        'person_type_id',
    ];

    public static function findByIdentification($identificationNumber): ?Client
    {
        return parent::where('identification_number', '=', $identificationNumber)->first();
    }
}
