<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SurveyQuestionOption extends Model
{
    use SoftDeletes;

    public $fillable = ['survey_question_id', 'option'];

    public function survey_question(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(SurveyQuestion::class);
    }
}
