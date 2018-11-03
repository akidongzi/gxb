<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class VideoRequest extends FormRequest
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
                    'title' => 'required|string|min:6|max:255',
                    'source' => 'nullable|string|max:32',
                    'poster' => 'nullable|string|max:125',
                    'editor' => 'required|string|max:125|min:2',
                    'sort' => 'nullable|numeric',
                ];
            default: {
                return [];
            }
        }
    }

    public function messages()
    {
        return [
            'title.required' => '请输入文章标题',
            'title.min' => '文章标题最少六个字符',
            'title.max' => '文章标题不可超过125个字符',
            'source.max' => '来源描述最多32个字符',
            'poster.required' => '请上传缩略图',
            'editor.required' => '请填写编辑名称',
            'editor.min' => '编辑名称至少为2个字符',
            'editor.max' => '编辑名称最多为125字符',
            'poster.max' => '缩略图文件名最多255个字符',
            'sort' => '排序必须是整形数字',
        ];
    }
}
