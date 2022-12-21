<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyParticipationData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_participation_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('question_id', false, true);
            $table->integer('participation_id', false, true)->nullable();
            $table->string('key')->nullable();
            $table->string('value')->nullable();
            $table->string('delete_reason')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_participation_data');
    }
}
