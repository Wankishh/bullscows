<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class GameCodeCustomRule implements Rule
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
        $pos1 = strpos($value, "1");
        $pos8 = strpos($value, "8");
        $pass = true;
        $len = strlen($value);

        if($pos1 !== false && $pos8 !== false) {
            for($i =0; $i < $len; $i++) {

                if($i === $len - 1) {
                    break;
                }

                if($value[$i] === "1" && isset($value[$i+2]) && $value[$i+2] === "8") {
                    $pass = false;
                    break;
                }

                if($value[$i] === "8" && isset($value[$i+2]) && $value[$i+2] === "1") {
                    $pass = false;
                    break;
                }
            }
        }

        return $pass;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid number. Do not place 8 and 1 with 1 index difference';
    }
}
