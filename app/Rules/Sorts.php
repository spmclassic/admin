<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Sorts implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($min,$max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $value >= $this->min && $value<= $this->max;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '排序值要在' . $this->min . '-' . $this->max.'之间';
    }
}
