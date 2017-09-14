<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PersonType
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 */
class PersonType extends Model
{
    const LEGAL_TYPE = 'Legal';
    const PHYSICAL_TYPE = 'Physical';

    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $created_at;
    /**
     * @var string
     */
    protected $updated_at;

    protected $fillable = ['name'];
}
