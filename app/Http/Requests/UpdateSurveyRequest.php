<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class UpdateSurveyRequest extends FormRequest
{

    public function rules()
    {
        return [
            'title' => 'required|unique:surveys,title,'.$this->survey.'|max:100',
            'user' => 'required|string|max:100',
            'description' => 'nullable|max:255',
            'expires_at' => 'nullable',
            'status' => 'nullable|max:50',
        ];
    }


    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ]));
    }


    public function messages()
    {
        return [
            'title.required' => 'Survey Title is required',
            'title.unique' => 'Survey Title is not available',
            'user.required' => 'Survey User is required'
        ];
    }
}
