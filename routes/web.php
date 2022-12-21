<?php

use App\Http\Controllers\Api\SurveyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (\App\DataTables\SurveyDataTable $dataTable) {
    return $dataTable->render('survey.index');
})->name('survey.app.index');
Route::get('survey/view/{survey_id}', [SurveyController::class, 'view'])->name('survey.app.view');
Route::post('survey/participation/submit', [SurveyController::class, 'submitParticipation'])->name('survey.app.submit');
