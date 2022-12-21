<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSurveyRequest;
use App\Http\Requests\UpdateSurveyRequest;
use App\Http\Resources\SurveyResource;
use App\Models\Survey;
use App\Models\SurveyParticipant;
use App\Models\SurveyParticipationData;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $data = Survey::query()->where('user', '=', $request->user)->get();
        return SurveyResource::collection($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function store(CreateSurveyRequest $request)
    {
        $data = $request->validated();
        $created = Survey::query()->create($data);
        return response()->json(['success' => true, 'message' => 'Survey was ADDED successfully', 'data' => $created]);
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
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function update(UpdateSurveyRequest $request, $id)
    {
        $data = $request->validated();
        $survey = Survey::query()->findOrFail($id);
        $updated = $survey->update($data);
        return response()->json(['success' => true, 'message' => 'Survey was UPDATED successfully', 'data' => $survey]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $survey = Survey::query()->findOrFail($id);
        $deleted = $survey->delete();
        return response()->json(['success' => true, 'message' => 'Survey was DELETED successfully', 'data' => []]);
    }

    public function view($survey_id)
    {
        $survey = Survey::with(['questions', 'participants'])->find($survey_id);
        return view('survey.view', ['survey' => $survey]);
    }

    public function submitParticipation(Request $request): \Illuminate\Http\RedirectResponse
    {
        $survey = Survey::with(['participants'])->find($request->survey_id);
        $user = $request->user;

        if($survey->whereHas('participants', function ($query) use ($user, $survey) {
            $query->where(['user' => $user, 'survey_id' => $survey->id]);
        })->exists())
            return redirect()->route('survey.app.index')->with('message', 'Participation Already Acknowledged')->with('m-class','alert-danger');

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

        return redirect()->route('survey.app.index')->with('message', 'Your Participation Has been Successfully Acknowledged')->with('m-class','alert-success');
    }
}
