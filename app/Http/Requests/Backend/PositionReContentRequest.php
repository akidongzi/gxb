<?php

namespace App\Http\Requests\Backend;

use App\Models\Position;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PositionReContentRequest extends FormRequest
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
            case 'save':
                return [
                    // 'content_type' => 'required',
                    'content_ids'  => [
                        'nullable',
                        'regex:/(^([0-9|,]+)$)/u',
                    ],
                ];
                break;
            default: {
                return [];
            }
        }
    }

    public function messages()
    {
        return [
            // 'content_type.required' => '请选择内容类型',
            'content_ids.regex'     => '内容id格式错误，请用半角逗号隔开',
        ];
    }
}
