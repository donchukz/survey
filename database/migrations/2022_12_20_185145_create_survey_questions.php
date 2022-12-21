<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('survey_id', false, true);
            $table->string('label')->nullable();
            $table->string('input_type')->nullable();
            $table->boolean('mandatory')->default(false);
            $table->string('multi_select_option')->default(false);
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
        Schema::dropIfExists('survey_questions');
    }
}
