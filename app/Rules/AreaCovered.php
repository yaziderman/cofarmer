<?php
namespace App\Rules;
use App\Fields;
use Illuminate\Contracts\Validation\Rule;

class AreaCovered implements Rule
{
    private $field_area = null;
    private $message = "";

    public function __construct($field_id)
    {

        $relatedFieldRes = Fields::find($field_id);
        if ($relatedFieldRes){
            $relatedField = $relatedFieldRes->first();
            $this->field_area = $relatedField->area;
        }else{
            $this->message = "The referred field is not available";
        }
        
    }

    public function passes($attribute, $value)
   {
     if (!$this->field_area)
        return false;

     if ($this->field_area >= $value)
        return true;

     $this->message = 'The Processed area cannot exceed the field area itself: '.$this->field_area;
     return false;
   }

     /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}