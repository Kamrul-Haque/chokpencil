<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->unique();
            $table->string('subtitle')->nullable();
            $table->string('level')->nullable();
            $table->string('difficulty')->nullable();
            $table->string('duration')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->string('topic')->nullable();
            $table->longText('description');
            $table->string('image_path')->nullable();
            $table->string('date_starting')->nullable();
            $table->unsignedBigInteger('institution_id')->nullable();
            $table->boolean('has_certificate')->default(true);
            $table->boolean('is_paid')->default(true);
            $table->float('total_marks', 5, 2)->unsigned()->default(0);
            $table->integer('completion_marks')->unsigned()->default(40);
            $table->decimal('fee', 7, 2)->unsigned()->nullable();
            $table->string('currency')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('institution_id')->references('id')->on('institutions');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
