<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponseAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('response_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('response_id');
            $table->text('answer')->nullable();
            $table->string('attachment_path')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('response_id')->references('id')->on('responses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('response_answers');
    }
}
