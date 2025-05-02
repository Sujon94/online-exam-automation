<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class ValidateCertAltTag implements Rule
{
    private Request $request;

    /**
     * Create a new rule instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
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
        if (isset($value)){
            if ($this->request->hasFile('course_certificate') || $this->request->post('pre_cert_image') != null){
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Please upload certificate for alter tag.';
    }
}
