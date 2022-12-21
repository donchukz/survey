<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSurveyQuestionOptionRequest;
use App\Http\Resources\SurveyResource;
use App\Models\SurveyQuestion;
use App\Models\SurveyQuestionOption;
use Illuminate\Http\Request;

class SurveyQuestionOptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index()
    {
        $survey_question_id = \request()->get('survey_question_id');
        $data = SurveyQuestionOption::query()->where('survey_question_id', '=', $survey_question_id)->get();
        return SurveyResource::collection($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function store(CreateSurveyQuestionOptionRequest $request)
    {
        $data = $request->validated();
        $input_type = SurveyQuestion::query()->findOrFail($data['survey_question_id'])->input_type;
        if(strtolower($input_type) != 'select')
            return response()->json(['success' => false, 'message' => 'You cannot add option for this Survey Question ['.strtoupper($input_type).']', 'data' => []]);

        $created = SurveyQuestionOption::query()->create($data);
        return response()->json(['success' => true, 'message' => 'Survey Question Option was ADDED successfully', 'data' => $created]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
