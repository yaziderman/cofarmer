<?php
namespace App\Rules;
use Illuminate\Contracts\Validation\Rule;
class ProcessFree implements Rule
{
    public function passes($attribute, $value)
   {
     // foreach ($value as $v) {
     //   if (!is_int($v)) {
     //     return false;
     //   }
     // }

     return false;
   }

     /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The given repository is invalid.';
    }
}