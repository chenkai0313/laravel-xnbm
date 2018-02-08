<?php

namespace Modules\Backend\Http\Requests\version;

use Illuminate\Validation\Rule;
use Modules\Backend\Http\Requests\BaseRequest;

class AddVersionRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'device'=>'required',
            'version'=>'required',
            'version_content'=>'required',
            'update_type'=>['required', Rule::in([1,2,3])],
            'update_mode'=>['required', Rule::in([1,2])],
            'version_url'=>'required_if:update_mode,2'
        ];
    }
    public function messages()
    {
        return [
            'device.required'=>'设备必填',
            'version.required'=>'版本必填',
            'version_content.required'=>'更新内容必填',
            'update_type.required'=>'更新类型必填',
            'update_mode.required'=>'更新方式必填',
            'update_type.in'=>'更新类型填写错误',
            'update_mode.in'=>'更新方式填写错误',
            'version_url.required_if'=>'更新方式为增量,url必填'
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
