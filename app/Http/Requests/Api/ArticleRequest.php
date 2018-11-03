<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class ArticleRequest extends Request
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
                return [
                    'title'     => 'required|string|min:6|max:255',
                    'covers'    => 'nullable|array',
                    'covers.*'  => 'required|url',
                    'brief'     => 'required|string|min:6|max:255',
                    'url'       => 'required|url',
                    'author'    => 'nullable|string|max:255',
                    'source'       => 'nullable|string|max:255',
                    'published_at' => 'required|date',
                    'content'      => 'required|string',
                    'atlases'      => 'nullable|array',
                    'atlases.*'    => 'nullable|array',
                    'atlases.*.brief' => 'string|min:3|max:255',
                    'atlases.*.cover' => 'url',
                    
                ];
            default: {
                return [];
            }
        }
    }

    public function messages()
    {
        return [
        ];
    }
}
