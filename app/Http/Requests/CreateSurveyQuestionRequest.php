<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class CreateSurveyQuestionRequest extends FormRequest
{

    public function rules()
    {
        return [
            'survey_id' => 'required|exists:surveys,id',
            'label' => 'required|unique:survey_questions',
            'input_type' => 'required',
            'mandatory' => 'nullable|boolean',
            'multi_select_option' => 'nullable|boolean',
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
}
