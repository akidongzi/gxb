<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * 自定义验证错误格式
 */
class Request extends FormRequest 
{
	protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->toArray();
        
        throw new HttpResponseException(response()->json([
        	'errno'  => 400,
        	'errors' => $errors,
        ], 400));
    }
}