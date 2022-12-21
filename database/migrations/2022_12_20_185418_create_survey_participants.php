<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyParticipants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_participants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('survey_id', false, true);
            $table->string('user', 100)->nullable();
            $table->string('comment')->nullable();
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
        Schema::dropIfExists('survey_participants');
    }
}
