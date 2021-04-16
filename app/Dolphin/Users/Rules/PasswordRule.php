<?php


namespace App\Dolphin\Users\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Class PasswordRule
 * @package App\Dolphin\Users\Rules
 */
class PasswordRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // TODO: Implement passes() method.
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message()
    {
        return 'The :attribute is not a valid password.';
    }
}
