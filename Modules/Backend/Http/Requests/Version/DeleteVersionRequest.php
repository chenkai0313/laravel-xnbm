<?php

namespace Modules\Backend\Http\Requests\version;

use Modules\Backend\Http\Requests\BaseRequest;

class DeleteVersionRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'=>'required'
        ];
    }
    public function messages()
    {
        return [
            'id.required'=>'version_id必填',
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
}
