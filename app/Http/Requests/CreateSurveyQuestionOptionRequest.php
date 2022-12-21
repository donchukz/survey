<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class CreateSurveyQuestionOptionRequest extends FormRequest
{

    public function rules()
    {
        return [
            'survey_question_id' => 'required|exists:survey_questions,id',
            'option' => 'required|unique:survey_question_options',
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
