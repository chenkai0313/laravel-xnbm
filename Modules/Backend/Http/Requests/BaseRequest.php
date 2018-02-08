<?php

namespace Modules\Backend\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class BaseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * 重新FormRequest->failedValidation方法
     * @param Validator $validator
     * @throws \Exception
     */
    protected function failedValidation(Validator $validator)
    {
        $message = $validator->errors()->first();
        throw new \Exception($message,99999);
    }
}
