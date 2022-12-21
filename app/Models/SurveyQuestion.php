<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SurveyQuestion extends Model
{
    use SoftDeletes;

    public $fillable = ['survey_id', 'label', 'input_type', 'mandatory', 'multi_select_option'];

    public function survey(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }

    public function options(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SurveyQuestionOption::class, 'survey_question_id');
    }
}
