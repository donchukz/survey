<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SurveyParticipationData extends Model
{
    use SoftDeletes;

    public $fillable = ['question_id', 'user', 'participation_id'];

    public function question(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(SurveyQuestion::class);
    }

    public function participation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(SurveyParticipant::class);
    }
}
