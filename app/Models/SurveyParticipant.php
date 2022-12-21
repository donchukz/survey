<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SurveyParticipant extends Model
{
    use SoftDeletes;

    public $fillable = ['survey_id', 'user'];

    public function survey(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }

    public function payload(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SurveyParticipationData::class, 'participation_id');
    }
}
