<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Tel implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        return preg_match('#^([0-9]{3,4}-)?[0-9]{7,8}$#',$value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '请填写正确的固定电话';
    }
}