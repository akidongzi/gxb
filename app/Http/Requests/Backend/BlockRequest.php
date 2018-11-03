<?php

namespace App\Http\Requests\Backend;

use App\Models\Position;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlockRequest extends FormRequest
{
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->route()->getActionMethod()) {
            case 'store':
            case 'update':
                return [
                    'title' => 'required|string|max:64',
                    'tpl'   => 'required|string|max:64',
                    'desc'  => 'required|string|max:255',

                ];
            default: {
                return [];
            }
        }
    }

    public function messages()
    {
        return [
            'title.required' => '请输入模块名称',
            'title.max' => '模块名称最多64个字符',
            'tpl.required' => '请选择模板路径',
            'tpl.max' => '模版路径最多64个字符',
            'desc.required' => '请输入模块描述',
            'desc.max' => '模版路径最多255个字符',
        ];
    }
}
