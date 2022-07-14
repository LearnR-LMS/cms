<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEfCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ef_courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('total_time_learning')->comment('Minute');
            $table->integer('total_question');
            $table->boolean('is_deleted')->default(0);
            $table->timestamps();
        });

        Schema::create('ef_scores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ef_course_id');
            $table->bigInteger('user_id');
            $table->integer('score');
            $table->tinyInteger('earn_status')
                ->default(1)
                ->comment("1. Pending, 2. Rejected, 3. Approved");
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
        Schema::dropIfExists('ef_scores');
        Schema::dropIfExists('ef_courses');
    }
}
