<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSurveyQuestionRequest;
use App\Http\Resources\SurveyResource;
use App\Models\Survey;
use App\Models\SurveyParticipant;
use App\Models\SurveyParticipationData;
use App\Models\SurveyQuestion;
use Illuminate\Http\Request;

class SurveyQuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index()
    {
        $survey_id = \request()->get('survey_id');
        $data = SurveyQuestion::query()->where('survey_id', '=', $survey_id)->get();
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
    public function store(CreateSurveyQuestionRequest $request)
    {
        $data = $request->validated();
        $created = SurveyQuestion::query()->create($data);
        return response()->json(['success' => true, 'message' => 'Survey Question was ADDED successfully', 'data' => $created]);
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

    public function view($survey_id)
    {
        $data = Survey::with(['questions', 'participants'])->find($survey_id);
        return response()->json(['success' => true, 'message' => 'Success', 'data' => $data]);
    }

    public function submitParticipation(Request $request): \Illuminate\Http\JsonResponse
    {
        $survey = Survey::with(['participants'])->find($request->survey_id);
        $user = $request->user;

        if($survey->whereHas('participants', function ($query) use ($user, $survey) {
            $query->where(['user' => $user, 'survey_id' => $survey->id]);
        })->exists())
            return response()->json(['success' => false, 'message' => 'Participation Already Acknowledged', 'data' => []]);

        $survey_participant = new SurveyParticipant();

        $survey_participant->survey_id = $request->survey_id;
        $survey_participant->user = $user;
        $survey_participant->save();

        foreach (collect($request->get('question')) as $key => $value) {
            $survey_participation_data = new SurveyParticipationData();
            $survey_participation_data->question_id = $value;
            $survey_participation_data->participation_id = $survey_participant->id;
            $survey_participation_data->key = collect($request->except(['survey_id', '_method', '_token', 'label', 'question', 'user']))->keys()[$key];
            $val = collect($request->except(['survey_id', '_method', '_token', 'label', 'question', 'user']))->values()[$key];
            $survey_participation_data->value = is_array($val) ? json_encode($val) : $val;
            $survey_participation_data->save();
        }
        return response()->json(['success' => true, 'message' => 'Your Participation Has been Successfully Acknowledged', 'data' => $survey_participant->payload]);
    }
}
