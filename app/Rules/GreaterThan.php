<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class GreaterThan implements Rule
{
    protected $limit;

    public function __construct(float $limit)
    {
        $this->limit = $limit;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value) : bool
    {
        return $value > $limit;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be greater than : ' . $this->limit . '.';
    }
}
