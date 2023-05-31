<?php

namespace App\Services\Generals\Abstracts;

use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

abstract class AbstractRequestValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    abstract public function authorize();

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules();

    public function makeValidation(){
        $validator = Validator::make($this->all(), $this->rules(), $this->messages());

        if($validator->fails()) {
            // throw new Exception($validator->messages()->first());
            throw new ValidationException($validator);
        }

        return true;
    }
}
