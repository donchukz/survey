<?php

use App\Http\Controllers\Api\SurveyController;
use App\Http\Controllers\Api\SurveyQuestionOptionsController;
use App\Http\Controllers\Api\SurveyQuestionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('survey', SurveyController::class);
Route::resource('survey-questions', SurveyQuestionsController::class);
Route::resource('survey-question-options', SurveyQuestionOptionsController::class);
Route::get('survey/question/view/{survey_id}', [SurveyQuestionsController::class, 'view']);
Route::post('survey/participation/submit', [SurveyQuestionsController::class, 'submitParticipation']);
